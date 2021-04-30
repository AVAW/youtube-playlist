<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/", name="user_profile")
     */
    public function index(): Response
    {
        return $this->render('user/profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }
}
