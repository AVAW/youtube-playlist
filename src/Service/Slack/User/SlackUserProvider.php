<?php

declare(strict_types=1);

namespace App\Service\Slack\User;

use App\Entity\Slack\SlackUser;
use App\Repository\Slack\SlackUserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class SlackUserProvider
{

    protected SlackUserRepository $repository;

    public function __construct(SlackUserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    /** @return SlackUser[] */
    public function findAll(): iterable
    {
        return $this->repository->findAll();
    }

    public function findBySlackUserId(string $userId): ?SlackUser
    {
        return $this->repository->findOneBy(['profileId' => $userId]);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(SlackUser $user)
    {
        $this->repository->save($user);
    }

    public function findByIdentifier(string $identifier): ?SlackUser
    {
        try {
            return $this->repository->findOneBy(['identifier' => $identifier]);
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function findByEmail(string $email): ?SlackUser
    {
        return $this->repository->findOneBy(['email' => $email]);
    }

}
