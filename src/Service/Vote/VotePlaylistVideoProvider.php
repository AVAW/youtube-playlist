<?php

declare(strict_types=1);

namespace App\Service\Vote;

use App\Entity\Playlist\PlaylistVideo;
use App\Entity\User\User;
use App\Entity\Vote\VotePlaylistVideo;
use App\Repository\Vote\VotePlaylistVideoRepository;

class VotePlaylistVideoProvider
{

    private VotePlaylistVideoRepository $repository;

    public function __construct(
        VotePlaylistVideoRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function findVote(
        string $action,
        PlaylistVideo $video,
        User $user,
        \DateTimeInterface $from,
        \DateTimeInterface $to
    ): ?VotePlaylistVideo {
        return $this->repository->findVote($action, $video, $user, $from, $to);
    }

    /**
     * @return VotePlaylistVideo[]
     */
    public function findAllVotes(string $action, PlaylistVideo $video, ?\DateTimeInterface $from, \DateTimeInterface $to): array
    {
        return $this->repository->findAllVotes($action, $video, $from, $to);
    }

}
