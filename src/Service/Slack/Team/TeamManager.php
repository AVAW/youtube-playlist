<?php

declare(strict_types=1);

namespace App\Service\Slack\Team;

use App\Entity\Slack\Team;
use Symfony\Component\Uid\Uuid;

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
            ->setDomain($teamDomain)
            ->setIdentifier(Uuid::v4());

        $this->provider->save($team);

        return $team;
    }

    public function update(
        Team $team,
        ?string $name,
        ?string $emailDomain,
        ?string $iconUrl
    ): void {
        $team
            ->setName($name)
            ->setEmailDomain($emailDomain)
            ->setIconUrl($iconUrl);

        // Force to update because Doctrine knows when entity didnt change
        $team->setUpdatedAt(new \DateTime());

        $this->provider->save($team);
    }

}
