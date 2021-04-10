<?php

declare(strict_types=1);

namespace App\Service\Playlist;

use App\Entity\Playlist\Playlist;
use App\Entity\Slack\Command;
use App\Entity\Slack\Conversation;
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
        ?int $amount,
        ?Command $command = null
    ): Playlist {
        $playlist = (new Playlist())
            ->setUrl($url)
            ->setYoutubeId($youTubeId)
            ->setTitle($title)
            ->setDescription($description)
            ->setPublishedAt($publishedAt)
            ->setChannelTitle($channelTitle)
            ->setVideosAmount($amount)
            ->setIdentifier(Uuid::v4())
            ->setCommand($command);

        $this->provider->save($playlist);

        return $playlist;
    }

}
