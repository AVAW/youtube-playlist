<?php

declare(strict_types=1);

namespace App\Service\Vote;

use App\Entity\Playlist\PlaylistVideo;
use App\Entity\User\User;
use App\Entity\Vote\VotePlaylistVideo;
use DateTimeInterface;
use Symfony\Component\Uid\UuidV4;

class VotePlaylistVideoManager
{

    private VoteProvider $provider;

    public function __construct(
        VoteProvider $provider
    ) {
        $this->provider = $provider;
    }

    public function create(
        string $action,
        User $user,
        PlaylistVideo $video,
        DateTimeInterface $votedAt
    ): VotePlaylistVideo {
        return (new VotePlaylistVideo())
            ->setAction($action)
            ->setUser($user)
            ->setVideo($video)
            ->setVotedAt($votedAt)
            ->setIdentifier(new UuidV4());
    }

}
