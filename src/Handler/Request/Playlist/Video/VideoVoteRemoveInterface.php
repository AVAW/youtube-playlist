<?php

declare(strict_types=1);

namespace App\Handler\Request\Playlist\Video;

use App\Entity\User\User;

interface VideoVoteRemoveInterface
{

    public function getUser(): User;

    public function getVideoIdentifier(): string;

    public function votedAt(): \DateTimeInterface;

}
