<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\UserPresence;

interface UserPresenceCreateOrUpdateInterface
{

    public function getAutoAway(): ?bool;

    public function getConnectionCount(): ?int;

    public function getLastActivity(): ?\DateTimeInterface;

    public function getManualAway(): ?bool;

    public function getOnline(): ?bool;

    public function getPresence(): ?string;

}
