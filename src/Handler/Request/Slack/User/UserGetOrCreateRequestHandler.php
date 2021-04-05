<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\User;

use App\Entity\Slack\User;
use App\Service\Slack\User\UserManager;
use App\Service\Slack\User\UserProvider;

class UserGetOrCreateRequestHandler
{

    private UserManager $userManager;
    private UserProvider $userProvider;

    public function __construct(
        UserManager $userManager,
        UserProvider $userProvider
    ) {
        $this->userManager = $userManager;
        $this->userProvider = $userProvider;
    }

    public function handle(UserGetOrCreateInterface $command): User
    {
        $user = $this->userProvider->findByUserId($command->getUserId());
        if (!$user instanceof User) {
            $user = $this->userManager->create(
                $command->getUserId(),
                $command->getUserName(),
            );
        }

        return $user;
    }

}
