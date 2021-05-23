<?php

declare(strict_types=1);

namespace App\Handler\Message\Playlist;

use App\Entity\Playlist\Playlist;
use App\Handler\Request\Playlist\Video\VideosCreateRequestHandler;
use App\Http\YouTube\PlaylistClient;
use App\Message\Playlist\PullPlaylistVideos;
use App\Model\Playlist\Video\VideosCreateRequest;
use App\Service\Playlist\PlaylistProvider;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class PullPlaylistVideosHandler implements MessageHandlerInterface
{

    private PlaylistClient $playlistClient;
    private VideosCreateRequestHandler $videosCreateRequestHandler;
    private PlaylistProvider $playlistProvider;

    public function __construct(
        PlaylistClient $playlistClient,
        PlaylistProvider $playlistProvider,
        VideosCreateRequestHandler $videosCreateRequestHandler
    ) {
        $this->playlistClient = $playlistClient;
        $this->playlistProvider = $playlistProvider;
        $this->videosCreateRequestHandler = $videosCreateRequestHandler;
    }

    public function __invoke(PullPlaylistVideos $pullPlaylistVideos)
    {
        $playlist = $this->playlistProvider->findByIdentifier($pullPlaylistVideos->getIdentifier());
        if (!$playlist instanceof Playlist) {
            throw new \InvalidArgumentException('Cannot find playlist with identifier: ' . $pullPlaylistVideos->getIdentifier());
        }

        $videos = $this->playlistClient->getPlaylistVideos($playlist->getYoutubeId());
        $createVideosRequest = VideosCreateRequest::create($videos);
        $this->videosCreateRequestHandler->handle($playlist, $createVideosRequest);
    }

}
