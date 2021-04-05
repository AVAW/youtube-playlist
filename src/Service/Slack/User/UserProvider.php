<?php

declare(strict_types=1);

namespace App\Service\Slack\User;

use App\Entity\Slack\User;
use App\Repository\Slack\UserRepository;

class UserProvider
{

    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function findByUserId(string $userId): ?User
    {
        return $this->userRepository->findOneBy(['userId' => $userId]);
    }

    public function save(User $user)
    {
        $this->userRepository->save($user);
    }

}
