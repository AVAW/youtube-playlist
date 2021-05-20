<?php

declare(strict_types=1);

namespace App\Service\Playlist\Video;

use App\Dto\Playlist\VideoDto;
use App\Entity\Playlist\Playlist;
use App\Entity\Playlist\PlaylistVideo;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
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
        DateTimeInterface $publishedAt,
        ?string $videoOwnerChannelId,
        ?string $videoOwnerChannelTitle
    ): PlaylistVideo {
        $video = (new PlaylistVideo())
            ->setVideoId($videoId)
            ->setTitle($title)
            ->setPublishedAt($publishedAt)
            ->setVideoOwnerChannelId($videoOwnerChannelId)
            ->setVideoOwnerChannelTitle($videoOwnerChannelTitle)
            ->setIdentifier(new UuidV4());

        if ($playlist instanceof Playlist) {
            $video->setPlaylist($playlist);
        }

        return $video;
    }

    /**
     * Batch Processing - Bulk Inserts
     * @param VideoDto[] $videos
     * @throws ORMException
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
                $video->videoOwnerChannelId,
                $video->videoOwnerChannelTitle,
            );

            $this->em->persist($playlistVideo);

            if (($i % $batchSize) === 0) {
                $this->em->flush();
                $this->em->clear();

                $playlist = $this->em->getReference(Playlist::class, $playlist->getId());
            }
        }

        $this->em->flush();
        $this->em->clear();
    }

}
