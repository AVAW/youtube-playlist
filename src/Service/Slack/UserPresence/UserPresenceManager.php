<?php

declare(strict_types=1);

namespace App\Service\Slack\UserPresence;

use App\Entity\Slack\User;
use App\Entity\Slack\UserPresence;

class UserPresenceManager
{

    private UserPresenceProvider $provider;

    public function __construct(UserPresenceProvider $provider)
    {
        $this->provider = $provider;
    }

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

    public function update(
        UserPresence $userPresence,
        ?bool $autoAway,
        ?int $connectionCount,
        ?\DateTimeInterface $lastActivity,
        ?bool $manualAway,
        ?bool $online,
        ?string $presence
    ): UserPresence {
        $userPresence
            ->setAutoAway($autoAway)
            ->setConnectionCount($connectionCount)
            ->setLastActivity($lastActivity)
            ->setManualAway($manualAway)
            ->setOnline($online)
            ->setPresence($presence);

        $this->provider->save($userPresence);

        return $userPresence;
    }

}
