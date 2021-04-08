<?php

declare(strict_types=1);

namespace App\Service\Playlist;

use App\Entity\Playlist;
use App\Repository\PlaylistRepository;

class PlaylistProvider
{

    protected PlaylistRepository $repository;

    public function __construct(PlaylistRepository $playlistRepository)
    {
        $this->repository = $playlistRepository;
    }

    public function findByIdentifier(string $identifier): ?Playlist
    {
        try {
            return $this->repository->findOneBy(['identifier' => $identifier]);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function save(Playlist $playlist)
    {
        $this->repository->save($playlist);
    }

}
