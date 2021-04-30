<?php

declare(strict_types=1);

namespace App\Service\Playlist\Play;

use App\Entity\Playlist\PlaylistPlay;
use App\Repository\Playlist\PlaylistPlayRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class PlaylistPlayProvider
{

    private PlaylistPlayRepository $repository;

    public function __construct(
        PlaylistPlayRepository $playlistPlayRepository
    ) {
        $this->repository = $playlistPlayRepository;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(PlaylistPlay $play)
    {
        $this->repository->save($play);
    }

}
