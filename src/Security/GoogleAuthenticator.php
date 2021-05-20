<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User\User;
use App\Service\Google\User\GoogleUserManager;
use App\Service\Google\User\GoogleUserProvider;
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

class GoogleAuthenticator extends OAuth2Authenticator
{

    private ClientRegistry $clientRegistry;
    private RouterInterface $router;
    private GoogleUserProvider $googleUserProvider;
    private UserProvider $userProvider;
    private UserManager $userManager;
    private GoogleUserManager $googleUserManager;

    public function __construct(
        ClientRegistry $clientRegistry,
        RouterInterface $router,
        GoogleUserProvider $googleUserProvider,
        UserProvider $userProvider,
        UserManager $userManager,
        GoogleUserManager $googleUserManager
    ) {
        $this->clientRegistry = $clientRegistry;
        $this->router = $router;
        $this->googleUserProvider = $googleUserProvider;
        $this->userProvider = $userProvider;
        $this->userManager = $userManager;
        $this->googleUserManager = $googleUserManager;
    }

    public function supports(Request $request): bool
    {
        return $request->attributes->get('_route') === 'connect_google_check';
    }

    public function authenticate(Request $request): PassportInterface
    {
        $credentials = $this->fetchAccessToken($this->clientRegistry->getClient('google'));

        return new SelfValidatingPassport(
            new UserBadge('NO_USER_ID_IN_CREDENTIALS', function ($userId) use ($credentials) {
                /** @var \League\OAuth2\Client\Provider\GoogleUser $googleUser */
                $googleUser = $this->clientRegistry->getClient('google')->fetchUserFromToken($credentials);

                // 1) Dose user logged in with Google before?
                $existingUser = $this->googleUserProvider->findByGoogleUserId($googleUser->getId());
                if ($existingUser) {
                    return $existingUser->getUser();
                }

                // 2) Do we have a matching user by email?
                $user = $this->userProvider->findByEmailInProfiles($googleUser->getEmail());
                if (!$user instanceof User) {
                    $user = $this->userManager->create(
                        null,
                        $googleUser->getEmail()
                    );
                }

                // 3) Creating GoogleUser
                $this->googleUserManager->create(
                    $user,
                    $googleUser->getId(),
                    $googleUser->getName(),
                    $googleUser->getEmail(),
                    $googleUser->getFirstName(),
                    $googleUser->getLastName(),
                    $googleUser->getLocale(),
                    $googleUser->getAvatar(),
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
