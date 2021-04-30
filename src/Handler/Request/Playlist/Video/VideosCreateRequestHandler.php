<?php

declare(strict_types=1);

namespace App\Handler\Request\Playlist\Video;

use App\Entity\Playlist\Playlist;
use App\Service\Playlist\Video\PlaylistVideoManager;

class VideosCreateRequestHandler
{

    private PlaylistVideoManager $videoManager;

    public function __construct(
        PlaylistVideoManager $videoManager
    ) {
        $this->videoManager = $videoManager;
    }

    public function handle(Playlist $playlist, VideosCreateInterface $command)
    {
        $this->videoManager->bulkInserts($playlist, $command->getVideos());
    }

}
