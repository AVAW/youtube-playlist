<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Playlist;
use App\Repository\PlaylistRepository;
use App\Response\JsonResponseMethods;
use App\Service\YouTubePlaylistManager;
use Doctrine\DBAL\Types\ConversionException;
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
     * @Route("/{uuid}", name="playlist")
     */
    public function index(
        $uuid,
        PlaylistRepository $playlistRepository,
        YouTubePlaylistManager $youTubePlaylistManager
    ): Response {
        try {
            $playlist = $playlistRepository->findOneBy(['uuid' => $uuid]);
        } catch (ConversionException $e) {
            throw new \InvalidArgumentException('Can not find playlist');
        }
        if (!$playlist instanceof Playlist) {
            throw new \InvalidArgumentException('Can not find playlist');
        }

        $youTubePlaylistManager->getPlaylistDetails($playlist);
        $youTubePlaylistManager->getVideosAmountInPlaylist($playlist);

        $playlistRepository->save($playlist);

        return $this->render('playlist/index.html.twig', [
            'playlist' => $playlist,
        ]);
    }

}
