<?php

declare(strict_types=1);

namespace App\Service\Slack;

use App\Entity\Slack\User;
use App\Repository\Slack\UserRepository;

class UserManager
{

    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function findByUserId(string $userId): ?User
    {
        return $this->userRepository->findOneBy(['userId' =>$userId]);
    }

    public function create(
        string $userId,
        string $userName
    ): User {
        $user = (new User())
            ->setUserId($userId)
            ->setName($userName);

        $this->userRepository->save($user);

        return $user;
    }

}
