<?php

declare(strict_types=1);

namespace App\Service\Playlist;

use App\Entity\Playlist;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Uid\Uuid;

class PlaylistManager
{

    protected PlaylistProvider $provider;

    public function __construct(PlaylistProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(
        string $url,
        string $youTubeId,
        ?string $title,
        ?string $description,
        ?\DateTimeInterface $publishedAt,
        ?string $channelTitle,
        ?int $amount
    ): Playlist {
        $playlist = (new Playlist())
            ->setUrl($url)
            ->setYoutubeId($youTubeId)
            ->setTitle($title)
            ->setDescription($description)
            ->setPublishedAt($publishedAt)
            ->setChannelTitle($channelTitle)
            ->setVideosAmount($amount)
            ->setIdentifier(Uuid::v4());

        $this->provider->save($playlist);

        return $playlist;
    }

}
