<?php

declare(strict_types=1);

namespace App\Service\Slack\UserPresence;

use App\Entity\Slack\User;
use App\Entity\Slack\UserPresence;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class UserPresenceManager
{

    private UserPresenceProvider $provider;

    public function __construct(UserPresenceProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(
        User $user,
        ?bool $autoAway,
        ?int $connectionCount,
        ?\DateTimeInterface $lastActivity,
        ?bool $manualAway,
        ?bool $online,
        ?string $presence
    ): UserPresence {
        $userPresence = (new UserPresence())
            ->setUser($user)
            ->setAutoAway($autoAway)
            ->setConnectionCount($connectionCount)
            ->setLastActivity($lastActivity)
            ->setManualAway($manualAway)
            ->setOnline($online)
            ->setPresence($presence);

        $this->provider->save($userPresence);

        return $userPresence;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(
        UserPresence $userPresence,
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
