<?php

declare(strict_types=1);

namespace App\Message\Playlist;

use Countable;

class PullPlaylistVideos implements Countable
{

    private string $playlistIdentifier;

    public function __construct(string $playlistIdentifier)
    {
        $this->playlistIdentifier = $playlistIdentifier;
    }

    public function getPlaylistIdentifier(): string
    {
        return $this->playlistIdentifier;
    }

    public function count():int
    {
        return 1;
    }

}
