<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/settings")
 */
class SettingsController extends AbstractController
{
    /**
     * @Route("/", name="user_settings")
     */
    public function index(): Response
    {
        return $this->render('user/settings/index.html.twig', [
            'controller_name' => 'SettingsController',
        ]);
    }
}
