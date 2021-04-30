<?php

declare(strict_types=1);

namespace App\Message\Playlist;

class PullPlaylistVideos
{

    private string $identifier;

    public function __construct(string $identifier)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

}
