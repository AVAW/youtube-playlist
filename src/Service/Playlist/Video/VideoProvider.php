<?php

declare(strict_types=1);

namespace App\Service\Playlist\Video;

use App\Entity\Playlist\PlaylistVideo;
use App\Repository\Playlist\PlaylistVideoRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class VideoProvider
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

}
