<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\UserPresence;

use App\Entity\Slack\SlackUser;
use App\Entity\Slack\SlackUserPresence;
use App\Service\Slack\UserPresence\SlackUserPresenceManager;
use App\Service\Slack\UserPresence\SlackUserPresenceProvider;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class UserPresenceCreateOrUpdateRequestHandler
{

    private SlackUserPresenceManager $userPresenceManager;
    private SlackUserPresenceProvider $userPresenceProvider;

    public function __construct(
        SlackUserPresenceManager $userPresenceManager,
        SlackUserPresenceProvider $userPresenceProvider
    ) {
        $this->userPresenceManager = $userPresenceManager;
        $this->userPresenceProvider = $userPresenceProvider;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle(SlackUser $user, UserPresenceCreateOrUpdateInterface $command): SlackUserPresence
    {
        $userPresence = $user->getPresence();
        if (!$userPresence instanceof SlackUserPresence) {
            $userPresence = $this->userPresenceManager->create(
                $user,
            );
        }

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

}
