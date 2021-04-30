<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Slack\SlackUser;
use App\Entity\User\User;
use App\Exception\NotImplementedException;
use App\Service\Slack\User\SlackUserManager;
use App\Service\Slack\User\SlackUserProvider;
use App\Service\User\UserManager;
use App\Service\User\UserProvider;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class SlackAuthenticator extends OAuth2Authenticator
{

    private ClientRegistry $clientRegistry;
    private RouterInterface $router;
    private UserProvider $userProvider;
    private SlackUserProvider $slackUserProvider;
    private UserManager $userManager;
    private SlackUserManager $slackUserManager;

    public function __construct(
        ClientRegistry $clientRegistry,
        RouterInterface $router,
        UserProvider $userProvider,
        UserManager $userManager,
        SlackUserProvider $slackUserProvider,
        SlackUserManager $slackUserManager
    ) {
        $this->clientRegistry = $clientRegistry;
        $this->router = $router;
        $this->userProvider = $userProvider;
        $this->userManager = $userManager;
        $this->slackUserProvider = $slackUserProvider;
        $this->slackUserManager = $slackUserManager;
    }

    public function supports(Request $request): bool
    {
        return $request->attributes->get('_route') === 'connect_slack_check';
    }

    public function authenticate(Request $request): PassportInterface
    {
        $credentials = $this->fetchAccessToken($this->clientRegistry->getClient('slack'));

        throw new NotImplementedException();

        return new SelfValidatingPassport(
            new UserBadge($credentials->getValues()['user_id'], function ($userId) use ($credentials) {
                /** @var  $slackUser */

                $slackUser = $this->clientRegistry->getClient('slack')->fetchUserFromToken($credentials);
                dd($slackUser);

                // 1) Dose user logged in with Slack before?
                $existingUser = $this->slackUserProvider->findBySlackUserId($slackUser->getId());
                if ($existingUser instanceof SlackUser) {
                    return $existingUser->getUser();
                }

                // 2) Do we have a matching user by email?
                $user = $this->userProvider->findByEmailInProfiles($slackUser->getEmail());
                if (!$user instanceof User) {
                    $user = $this->userManager->create(
                        null,
                        $slackUser->getEmail(),
                    );
                }

                // 3) Creating a SlackUser
                $this->slackUserManager->create(
                    $user,
                    $userId,

                );

                return $user;
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $targetUrl = $this->router->generate('home');

        return new RedirectResponse($targetUrl);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        return new Response($message, Response::HTTP_FORBIDDEN);
    }

}
