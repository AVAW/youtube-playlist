<?php

declare(strict_types=1);

namespace App\Service\Playlist\Video;

use App\Entity\Playlist\Playlist;
use App\Entity\Playlist\PlaylistVideo;
use App\Repository\Playlist\PlaylistVideoRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class PlaylistVideoProvider
{

    protected PlaylistVideoRepository $repository;

    public function __construct(
        PlaylistVideoRepository $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(PlaylistVideo $video)
    {
        $this->repository->save($video);
    }

    public function findByIdentifier(string $identifier): ?PlaylistVideo
    {
        try {
            return $this->repository->findOneBy(['identifier' => $identifier]);
        } catch (\Throwable $e) {
            return null;
        }
    }

}
