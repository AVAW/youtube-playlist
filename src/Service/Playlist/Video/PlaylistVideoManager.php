<?php

declare(strict_types=1);

namespace App\Service\Playlist\Video;

use App\Dto\Playlist\VideoDto;
use App\Entity\Playlist\Playlist;
use App\Entity\Playlist\PlaylistVideo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\UuidV4;

class PlaylistVideoManager
{

    protected PlaylistVideoProvider $provider;
    private EntityManagerInterface $em;

    public function __construct(
        PlaylistVideoProvider $provider,
        EntityManagerInterface $entityManager
    ) {
        $this->provider = $provider;
        $this->em = $entityManager;
    }

    public function create(
        Playlist $playlist,
        string $videoId,
        string $title,
        \DateTimeInterface $publishedAt
    ): PlaylistVideo {
        return (new PlaylistVideo())
            ->setPlaylist($playlist)
            ->setVideoId($videoId)
            ->setTitle($title)
            ->setPublishedAt($publishedAt)
            ->setIdentifier(new UuidV4());
    }

    /**
     * Batch Processing - Bulk Inserts
     * @param VideoDto[] $videos
     */
    public function bulkInserts(Playlist $playlist, array $videos)
    {
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);

        $videosAmount = count($videos);
        $batchSize = 50;
        for ($i = 0; $i < $videosAmount; $i++) {
            $video = $videos[$i];

            $playlistVideo = $this->create(
                $playlist,
                $video->id,
                $video->title,
                $video->publishedAt,
            );

            $this->em->persist($playlistVideo);

            if (($i % $batchSize) === 0) {
                $this->em->flush();
                $this->em->clear();
            }
        }

        $this->em->flush();
        $this->em->clear();
    }

}
