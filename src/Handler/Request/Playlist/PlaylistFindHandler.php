<?php

declare(strict_types=1);

namespace App\Handler\Request\Playlist;

use App\Entity\Playlist\Playlist;
use App\Service\Playlist\PlaylistProvider;

class PlaylistFindHandler
{

    private PlaylistProvider $playlistProvider;

    public function __construct(
        PlaylistProvider $playlistProvider
    ) {
        $this->playlistProvider = $playlistProvider;
    }

    public function handle(PlaylistFindInterface $command): ?Playlist
    {
        return $this->playlistProvider->findByIdentifier($command->getIdentifier());
    }

}
