<?php

declare(strict_types=1);

namespace App\Model\Slack\Command;

interface CommandTeamInterface
{

    public function getTeamId(): string;

    public function getTeamDomain(): string;

}
