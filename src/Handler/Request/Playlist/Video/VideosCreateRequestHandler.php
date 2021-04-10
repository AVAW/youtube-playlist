<?php

declare(strict_types=1);

namespace App\Handler\Request\Playlist\Video;

use App\Entity\Playlist\Playlist;
use App\Http\YouTube\PlaylistClient;
use App\Service\Playlist\Video\VideoManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class VideosCreateRequestHandler
{

    private PlaylistClient $playlistClient;
    private VideoManager $videoManager;

    public function __construct(
        PlaylistClient $playlistClient,
        VideoManager $videoManager
    ) {
        $this->playlistClient = $playlistClient;
        $this->videoManager = $videoManager;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle(Playlist $playlist, VideosCreateInterface $command)
    {
        foreach ($command->getVideos() as $video) {
            $this->videoManager->create(
                $playlist,
                $video->id,
                $video->title,
                $video->publishedAt
            );
        }
    }

}
