<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User\User;
use App\Repository\User\UserRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class UserProvider
{

    private UserRepository $repository;

    public function __construct(
        UserRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function findByIdentifier(string $identifier): ?User
    {
        try {
            return $this->repository->findOneBy(['identifier' => $identifier]);
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function findByEmail(string $email): ?User
    {
        return $this->repository->findOneBy(['email' => $email]);
    }

    public function findByEmailInProfiles(string $email): ?User
    {
        try {
            return $this->repository->findOneByEmailInProfiles($email);
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(User $user)
    {
        $this->repository->save($user);
    }

}
