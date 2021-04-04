<?php

declare(strict_types=1);

namespace App\Handler\Request;

use App\Entity\Playlist;
use App\Model\Playlist\PlaylistUuidInterface;
use App\Service\PlaylistManager;

class PlaylistHandler
{

    private PlaylistManager $playlistManager;

    public function __construct(
        PlaylistManager $playlistManager
    ) {
        $this->playlistManager = $playlistManager;
    }

    public function handle(PlaylistUuidInterface $command): ?Playlist
    {
        return $this->playlistManager->findByUuid($command->getUuid());
    }

}
