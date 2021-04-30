<?php

declare(strict_types=1);

namespace App\Controller\Security\Connect;

use App\Exception\NotImplementedException;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/connect/slack")
 */
class SlackController extends AbstractController
{

    /**
     * @Route("/connect", name="connect_slack_connect")
     */
    public function connect(
        ClientRegistry $clientRegistry
    ): Response {
        throw new NotImplementedException('Not working');

        return $clientRegistry
            ->getClient('slack')
            ->redirect([
                'users:read',
                'users:read.email',
            ], [
                'redirect_uri' => 'http://localhost:8080/connect/slack/check',
            ]);
    }

    /**
     * @Route("/check", name="connect_slack_check")
     */
    public function check(
        Request $request,
        ClientRegistry $clientRegistry
    ) {
        throw new NotImplementedException('Not working');

        $client = $clientRegistry->getClient('slack');

        try {
            // the exact class depends on which provider you're using
            $user = $client->fetchUser();
            dd($user);
            // e.g. $name = $user->getFirstName();
        } catch (IdentityProviderException $e) {
            // something went wrong!
            // probably you should return the reason to the user
            dd($e->getMessage());
        }
    }

}
