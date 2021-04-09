<?php

declare(strict_types=1);

namespace App\Service\Slack\User;

use App\Entity\Slack\User;
use App\Repository\Slack\UserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class UserProvider
{

    protected UserRepository $repository;

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    /** @return User[] */
    public function findAll(): iterable
    {
        return $this->repository->findAll();
    }

    public function findByUserId(string $userId): ?User
    {
        return $this->repository->findOneBy(['userId' => $userId]);
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
