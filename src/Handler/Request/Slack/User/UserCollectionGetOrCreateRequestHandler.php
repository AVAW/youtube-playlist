<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\User;

use App\Entity\Slack\Conversation;
use App\Entity\Slack\User;
use App\Event\Slack\NewUserEvent;
use App\Service\Slack\User\UserManager;
use App\Service\Slack\User\UserProvider;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class UserCollectionGetOrCreateRequestHandler
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

    /** @return User[] */
    public function handle(Conversation $conversation, UserCollectionGetOrCreateInterface $command): array
    {
        $users = [];
        foreach ($command->getUsersIds() as $usersId) {
            $user = $this->userProvider->findByUserId($usersId);
            if ($user instanceof User) {
                $users [] = $user;
                continue;
            }

            $user = $this->userManager->create(
                $usersId,
                null,
                null,
                $conversation
            );

            $this->dispatcher->dispatch(new NewUserEvent($user));
        }

        return $users;
    }

}
