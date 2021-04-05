<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Playlist;
use App\Form\PlaylistType;
use App\Handler\Request\Playlist\PlaylistFindHandler;
use App\Model\Playlist\PlaylistFindRequest;
use App\Service\YouTubePlaylistManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/playlist")
 */
class PlaylistController extends AbstractFOSRestController
{

    /**
     * @Route("/videos", methods={"POST"})
     * @FOSRest\View(serializerGroups={"simple"})
     */
    public function videos(
        Request $request,
        PlaylistFindHandler $playlistHandler,
        YouTubePlaylistManager $youTubePlaylistManager
    ): Response {
        $command = new PlaylistFindRequest();
        $form = $this->createForm(PlaylistType::class, $command);
        $form->submit($request->toArray());

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var PlaylistFindRequest $command */
            $command = $form->getData();

            $playlist = $playlistHandler->handle($command);
            if (!$playlist instanceof Playlist) {
                throw new \InvalidArgumentException('Can not find playlist');
            }

            $videos = $youTubePlaylistManager->getPlaylistVideos($playlist);

            return $this->handleView(View::create([
                'playlist' => $playlist,
                'videos' => $videos,
            ]));
        }

        return $this->handleView(View::create(['form' => $form]));
    }

}
