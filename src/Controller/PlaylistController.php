<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Playlist;
use App\Response\JsonResponseMethods;
use App\Service\Playlist\PlaylistProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/playlist")
 */
class PlaylistController extends AbstractController
{

    use JsonResponseMethods;

    /**
     * @Route("/")
     */
    public function none()
    {
        $this->redirectToRoute('home');
    }

    /**
     * @Route("/{identifier}", name="playlist")
     */
    public function index(
        $identifier,
        PlaylistProvider $playlistProvider
    ): Response {
        $playlist = $playlistProvider->findByIdentifier($identifier);
        if (!$playlist instanceof Playlist) {
            throw new \InvalidArgumentException('Can not find playlist');
        }

        return $this->render('playlist/index.html.twig', [
            'playlist' => $playlist,
        ]);
    }

}
