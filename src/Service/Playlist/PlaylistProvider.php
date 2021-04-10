<?php

declare(strict_types=1);

namespace App\Service\Playlist;

use App\Entity\Playlist\Playlist;
use App\Repository\Playlist\PlaylistRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

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
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Playlist $playlist)
    {
        $this->repository->save($playlist);
    }

}
