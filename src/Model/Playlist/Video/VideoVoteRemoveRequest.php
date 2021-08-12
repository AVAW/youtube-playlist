<?php

declare(strict_types=1);

namespace App\Model\Playlist\Video;

use App\Entity\User\User;
use App\Handler\Request\Playlist\Video\VideoVoteRemoveInterface;

class VideoVoteRemoveRequest implements VideoVoteRemoveInterface
{

    private User $user;
    private string $videoIdentifier;
    private \DateTimeInterface $votedAt;

    public static function create(
        User $user,
        string $videoIdentifier,
        \DateTimeInterface $createAt
    ): self {
        return (new static)
            ->setUser($user)
            ->setVideoIdentifier($videoIdentifier)
            ->setVotedAt($createAt);
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getVideoIdentifier(): string
    {
        return $this->videoIdentifier;
    }

    public function setVideoIdentifier(string $videoIdentifier): self
    {
        $this->videoIdentifier = $videoIdentifier;

        return $this;
    }

    public function getVotedAt(): \DateTimeInterface
    {
        return $this->votedAt;
    }

    public function setVotedAt(\DateTimeInterface $votedAt): self
    {
        $this->votedAt = $votedAt;

        return $this;
    }

    public function votedAt(): \DateTimeInterface
    {
        return $this->votedAt;
    }

}
