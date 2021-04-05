<?php

declare(strict_types=1);

namespace App\Service\Slack\Team;

use App\Entity\Slack\Team;

class TeamManager
{

    protected TeamProvider $provider;

    public function __construct(TeamProvider $provider)
    {
        $this->provider = $provider;
    }

    public function create(
        string $teamId,
        string $teamDomain
    ): Team {
        $team = (new Team())
            ->setTeamId($teamId)
            ->setDomain($teamDomain);

        $this->provider->save($team);

        return $team;
    }

    public function update(
        Team $team,
        ?string $name,
        ?string $emailDomain,
        ?string $iconUrl
    ) {
        $team
            ->setName($name)
            ->setEmailDomain($emailDomain)
            ->setIconUrl($iconUrl);

        $this->provider->save($team);
    }

}
