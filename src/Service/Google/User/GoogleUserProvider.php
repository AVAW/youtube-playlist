<?php

declare(strict_types=1);

namespace App\Service\Google\User;

use App\Entity\Google\GoogleUser;
use App\Repository\Google\GoogleUserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class GoogleUserProvider
{

    private GoogleUserRepository $repository;

    public function __construct(
        GoogleUserRepository $googleUserRepository
    ) {
        $this->repository = $googleUserRepository;
    }

    public function findByGoogleUserId(string $userId): ?GoogleUser
    {
        return $this->repository->findOneBy(['profileId' => $userId]);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(GoogleUser $googleProfile)
    {
        $this->repository->save($googleProfile);
    }

}
