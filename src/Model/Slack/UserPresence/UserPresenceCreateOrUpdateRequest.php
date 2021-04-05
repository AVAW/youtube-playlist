<?php

declare(strict_types=1);

namespace App\Model\Slack\UserPresence;

use App\Handler\Request\Slack\UserPresence\UserPresenceCreateOrUpdateInterface;
use JoliCode\Slack\Api\Model\UsersGetPresenceGetResponse200;

class UserPresenceCreateOrUpdateRequest implements UserPresenceCreateOrUpdateInterface
{

    private ?bool $autoAway;
    private ?int $connectionCount;
    private ?\DateTimeInterface $lastActivity;
    private ?bool $manualAway;
    private ?bool $online;
    private ?string $presence;

    public static function createFromUserPresence(UsersGetPresenceGetResponse200 $presence): self
    {
        $object = (new static)
            ->setAutoAway($presence->getAutoAway())
            ->setConnectionCount($presence->getConnectionCount())
            ->setManualAway($presence->getManualAway())
            ->setOnline($presence->getOnline())
            ->setPresence($presence->getPresence());

        if ($presence->getLastActivity()) {
            $object->setLastActivity(\DateTime::createFromFormat('U', $presence->getLastActivity()));
        } else {
            $object->setLastActivity(null);
        }

        return $object;
    }

    public function getAutoAway(): ?bool
    {
        return $this->autoAway;
    }

    public function setAutoAway(?bool $autoAway): self
    {
        $this->autoAway = $autoAway;

        return $this;
    }

    public function getConnectionCount(): ?int
    {
        return $this->connectionCount;
    }

    public function setConnectionCount(?int $connectionCount): self
    {
        $this->connectionCount = $connectionCount;

        return $this;
    }

    public function getLastActivity(): ?\DateTimeInterface
    {
        return $this->lastActivity;
    }

    public function setLastActivity(?\DateTimeInterface $lastActivity): self
    {
        $this->lastActivity = $lastActivity;

        return $this;
    }

    public function getManualAway(): ?bool
    {
        return $this->manualAway;
    }

    public function setManualAway(?bool $manualAway): self
    {
        $this->manualAway = $manualAway;

        return $this;
    }

    public function getOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(?bool $online): self
    {
        $this->online = $online;

        return $this;
    }

    public function getPresence(): ?string
    {
        return $this->presence;
    }

    public function setPresence(?string $presence): self
    {
        $this->presence = $presence;

        return $this;
    }

}
