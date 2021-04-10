<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Playlist\Playlist;
use App\Service\Playlist\PlaylistProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/playlist")
 */
class PlaylistController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function index()
    {
        $this->redirectToRoute('home');
    }

    /**
     * @Route("/{identifier}", name="playlist")
     */
    public function playlist(
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
