<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Repository\PlaylistRepository;
use App\Response\JsonResponseMethods;
use App\Service\YouTubePlaylistManager;
use Doctrine\DBAL\Types\ConversionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/videos")
     */
    public function videos(
        Request $request,
        PlaylistRepository $playlistRepository,
        YouTubePlaylistManager $youTubePlaylistManager
    ): Response {
        $content = (array) json_decode($request->getContent());

        if (empty($content['uuid'])) {
            throw new \InvalidArgumentException('Can not find playlist');
        }
        try {
            $playlist = $playlistRepository->findOneBy(['uuid' => $content['uuid']]);
        } catch (ConversionException $e) {
            throw new \InvalidArgumentException('Can not find playlist');
        }
        if (!$playlist instanceof Playlist) {
            throw new \InvalidArgumentException('Can not find playlist');
        }

        $videos = $youTubePlaylistManager->getPlaylistVideos($playlist);

        return $this->jsonSuccess([
            'playlist' => [
                'uuid' => $playlist->getUuid(),
                'videos' => $videos,
            ],
        ]);
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

        return $this->render('playlist/index.html.twig', [
            'playlist' => $playlist,
        ]);
    }

}
