<?php

declare(strict_types=1);

namespace App\Handler\Request;

use App\Entity\Slack\User;
use App\Model\Slack\Command\CommandUserInterface;
use App\Service\Slack\UserManager;

class UserRequestHandler
{

    private UserManager $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function handle(CommandUserInterface $command): User
    {
        $user = $this->userManager->findByUserId($command->getUserId());
        if (!$user instanceof User) {
            $user = $this->userManager->create($command->getUserId(), $command->getUserName());
        }

        return $user;
    }

}
