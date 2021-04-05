<?php

namespace App\Handler\Request\Slack\UserPresence;

use App\Entity\Slack\User;
use App\Entity\Slack\UserPresence;
use App\Service\Slack\User\UserProvider;
use App\Service\Slack\UserPresence\UserPresenceManager;
use App\Service\Slack\UserPresence\UserPresenceProvider;

class UserPresenceCreateOrUpdateRequestHandler
{

    private UserPresenceManager $userPresenceManager;
    private UserPresenceProvider $userPresenceProvider;
    private UserProvider $userProvider;

    public function __construct(
        UserPresenceManager $userPresenceManager,
        UserPresenceProvider $userPresenceProvider,
        UserProvider $userProvider
    ) {
        $this->userPresenceManager = $userPresenceManager;
        $this->userPresenceProvider = $userPresenceProvider;
        $this->userProvider = $userProvider;
    }

    public function handle(User $user, UserPresenceCreateOrUpdateInterface $command): UserPresence
    {
        $userPresence = $user->getPresence();
        if ($userPresence instanceof UserPresence) {
            $this->userPresenceManager->update(
                $userPresence,
                $command->getAutoAway(),
                $command->getConnectionCount(),
                $command->getLastActivity(),
                $command->getManualAway(),
                $command->getOnline(),
                $command->getPresence(),
            );

            return $userPresence;
        }

        $userPresence = $this->userPresenceManager->create(
            $user,
            $command->getAutoAway(),
            $command->getConnectionCount(),
            $command->getLastActivity(),
            $command->getManualAway(),
            $command->getOnline(),
            $command->getPresence(),
        );

        return $userPresence;
    }

}
