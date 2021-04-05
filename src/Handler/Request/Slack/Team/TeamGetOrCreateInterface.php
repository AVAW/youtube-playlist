<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Team;

interface TeamGetOrCreateInterface
{

    public function getTeamId(): string;

    public function getTeamDomain(): string;

}
