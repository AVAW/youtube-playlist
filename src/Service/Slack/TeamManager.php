<?php

declare(strict_types=1);

namespace App\Service\Slack;

use App\Entity\Slack\Team;
use App\Repository\Slack\TeamRepository;

class TeamManager
{

    protected TeamRepository $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function findByTeamId(string $teamId): ?Team
    {
        return $this->teamRepository->findOneBy(['teamId' => $teamId]);
    }

    public function create(
        string $teamId,
        string $teamDomain
    ): Team {
        $team = (new Team())
            ->setTeamId($teamId)
            ->setDomain($teamDomain);

        $this->teamRepository->save($team);

        return $team;
    }

}
