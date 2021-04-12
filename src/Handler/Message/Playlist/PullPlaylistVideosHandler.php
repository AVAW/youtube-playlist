<?php

declare(strict_types=1);

namespace App\Handler\Message\Playlist;

use App\Handler\Request\Playlist\PlaylistFindHandler;
use App\Handler\Request\Playlist\Video\VideosCreateRequestHandler;
use App\Http\YouTube\PlaylistClient;
use App\Message\Playlist\PullPlaylistVideos;
use App\Model\Playlist\PlaylistFindRequest;
use App\Model\Playlist\Video\VideosCreateRequest;
use App\Service\Playlist\PlaylistProvider;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class PullPlaylistVideosHandler implements MessageHandlerInterface
{

    private PlaylistFindHandler $playlistFindHandler;
    private PlaylistProvider $playlistProvider;
    private PlaylistClient $playlistClient;
    private VideosCreateRequestHandler $videosCreateRequestHandler;

    public function __construct(
        PlaylistFindHandler $playlistFindHandler,
        PlaylistProvider $playlistProvider,
        PlaylistClient $playlistClient,
        VideosCreateRequestHandler $videosCreateRequestHandler
    ) {
        $this->playlistFindHandler = $playlistFindHandler;
        $this->playlistProvider = $playlistProvider;
        $this->playlistClient = $playlistClient;
        $this->videosCreateRequestHandler = $videosCreateRequestHandler;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function __invoke(PullPlaylistVideos $pullPlaylistVideos)
    {
        $findPlaylistRequest = PlaylistFindRequest::create($pullPlaylistVideos->getPlaylistIdentifier());
        $playlist = $this->playlistFindHandler->handle($findPlaylistRequest);

        $videos = $this->playlistClient->getPlaylistVideos($playlist->getYoutubeId());
        $createVideosRequest = VideosCreateRequest::create($videos);
        $this->videosCreateRequestHandler->handle($playlist, $createVideosRequest);
    }

}
