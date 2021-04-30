<?php

declare(strict_types=1);

namespace App\Service\Slack\UserPresence;

use App\Entity\Slack\SlackUser;
use App\Entity\Slack\SlackUserPresence;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class SlackUserPresenceManager
{

    private SlackUserPresenceProvider $provider;

    public function __construct(SlackUserPresenceProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(
        SlackUser $user,
        ?bool $autoAway = null,
        ?int $connectionCount = null,
        ?\DateTimeInterface $lastActivity = null,
        ?bool $manualAway = null,
        ?bool $online = null,
        ?string $presence = null
    ): SlackUserPresence {
        return (new SlackUserPresence())
            ->setUser($user)
            ->setAutoAway($autoAway)
            ->setConnectionCount($connectionCount)
            ->setLastActivity($lastActivity)
            ->setManualAway($manualAway)
            ->setOnline($online)
            ->setPresence($presence);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(
        SlackUserPresence $userPresence,
        ?bool $autoAway,
        ?int $connectionCount,
        ?\DateTimeInterface $lastActivity,
        ?bool $manualAway,
        ?bool $online,
        ?string $presence
    ): void {
        $userPresence
            ->setAutoAway($autoAway)
            ->setConnectionCount($connectionCount)
            ->setLastActivity($lastActivity)
            ->setManualAway($manualAway)
            ->setOnline($online)
            ->setPresence($presence);

        // Force to update because Doctrine knows when entity didnt change
        $userPresence->setUpdatedAt(new \DateTime());

        $this->provider->save($userPresence);
    }

}
