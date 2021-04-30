<?php

declare(strict_types=1);

namespace App\Controller\Security\Connect;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/connect/google")
 */
class GoogleController extends AbstractController
{

    /**
     * @Route("/connect", name="connect_google_connect")
     */
    public function connect(
        ClientRegistry $clientRegistry
    ): Response {
        return $clientRegistry
            ->getClient('google')
            ->redirect([
                // the scopes you want to access
                'openid',
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/userinfo.profile',
            ], [
                'redirect_uri' => 'http://localhost:8080/connect/google/check',
//                'redirect_uri' => 'http://d8a0b3252c77.ngrok.io/connect/google/check',
            ]);
    }

    /**
     * @Route("/check", name="connect_google_check")
     */
    public function check(
        ClientRegistry $clientRegistry
    ): Response {
        $client = $clientRegistry->getClient('google');

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
