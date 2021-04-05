<?php

declare(strict_types=1);

namespace App\Service\Slack\Team;

use App\Entity\Slack\Team;
use App\Repository\Slack\TeamRepository;

class TeamProvider
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

    public function save(Team $team)
    {
        $this->teamRepository->save($team);
    }

}
