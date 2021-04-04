<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Playlist;
use App\Repository\PlaylistRepository;

class PlaylistManager
{

    protected PlaylistRepository $playlistRepository;

    public function __construct(PlaylistRepository $playlistRepository)
    {
        $this->playlistRepository = $playlistRepository;
    }

    public function findByUuid(string $uuid): ?Playlist
    {
        try {
            return $this->playlistRepository->findOneBy(['uuid' => $uuid]);
        } catch (\Exception $e) {
            return null;
        }
    }

}
