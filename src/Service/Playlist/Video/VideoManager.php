<?php

declare(strict_types=1);

namespace App\Service\Playlist\Video;

use App\Entity\Playlist\Playlist;
use App\Entity\Playlist\PlaylistVideo;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Uid\UuidV4;

class VideoManager
{

    protected VideoProvider $provider;

    public function __construct(
        VideoProvider $provider
    ) {
        $this->provider = $provider;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(
        Playlist $playlist,
        string $videoId,
        string $title,
        \DateTimeInterface $publishedAt
    ): PlaylistVideo {
        $video = (new PlaylistVideo())
            ->setPlaylist($playlist)
            ->setVideoId($videoId)
            ->setTitle($title)
            ->setPublishedAt($publishedAt)
            ->setIdentifier(new UuidV4());

        $this->provider->save($video);

        return $video;
    }

}
