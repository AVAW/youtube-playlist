<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Team;

use App\Entity\Slack\Team;
use App\Service\Slack\Team\TeamManager;
use App\Service\Slack\Team\TeamProvider;

class TeamGetOrCreateRequestHandler
{

    private TeamManager $teamManager;
    private TeamProvider $teamProvider;

    public function __construct(
        TeamManager $teamManager,
        TeamProvider $teamProvider
    ) {
        $this->teamManager = $teamManager;
        $this->teamProvider = $teamProvider;
    }

    public function handle(TeamGetOrCreateInterface $command): Team
    {
        $team = $this->teamProvider->findOneByTeamId($command->getTeamId());
        if (!$team instanceof Team) {
            $team = $this->teamManager->create($command->getTeamId(), $command->getTeamDomain());
        }

        return $team;
    }

}
