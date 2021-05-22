<?php

declare(strict_types=1);

namespace App\Model\Slack\Team;

use App\Handler\Request\Slack\Team\TeamGetOrCreateInterface;

class TeamGetOrCreateRequest implements TeamGetOrCreateInterface
{

    protected string $teamId;
    protected string $teamDomain;

    public function getTeamId(): string
    {
        return $this->teamId;
    }

    public function setTeamId(string $teamId): self
    {
        $this->teamId = $teamId;

        return $this;
    }

    public function getTeamDomain(): string
    {
        return $this->teamDomain;
    }

    public function setTeamDomain(string $teamDomain): self
    {
        $this->teamDomain = $teamDomain;

        return $this;
    }

}
