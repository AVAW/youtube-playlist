<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\User;

use App\Entity\Slack\User;
use App\Event\Slack\NewUserEvent;
use App\Service\Slack\User\UserManager;
use App\Service\Slack\User\UserProvider;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class UserGetOrCreateRequestHandler
{

    private EventDispatcherInterface $dispatcher;
    private UserManager $userManager;
    private UserProvider $userProvider;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        UserManager $userManager,
        UserProvider $userProvider
    ) {
        $this->dispatcher = $dispatcher;
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

            $this->dispatcher->dispatch(new NewUserEvent($user));
        }

        return $user;
    }

}
