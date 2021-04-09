<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\UserPresence;

use App\Entity\Slack\User;
use App\Entity\Slack\UserPresence;
use App\Service\Slack\UserPresence\UserPresenceManager;
use App\Service\Slack\UserPresence\UserPresenceProvider;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class UserPresenceCreateOrUpdateRequestHandler
{

    private UserPresenceManager $userPresenceManager;
    private UserPresenceProvider $userPresenceProvider;

    public function __construct(
        UserPresenceManager $userPresenceManager,
        UserPresenceProvider $userPresenceProvider
    ) {
        $this->userPresenceManager = $userPresenceManager;
        $this->userPresenceProvider = $userPresenceProvider;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
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
