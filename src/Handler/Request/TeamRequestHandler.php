<?php

declare(strict_types=1);

namespace App\Handler\Request;

use App\Entity\Slack\Team;
use App\Model\Slack\Command\CommandTeamInterface;
use App\Service\Slack\TeamManager;

class TeamRequestHandler
{

    private TeamManager $teamManager;

    public function __construct(
        TeamManager $teamManager
    ) {
        $this->teamManager = $teamManager;
    }

    public function handle(CommandTeamInterface $command): Team
    {
        $team = $this->teamManager->findByTeamId($command->getTeamId());
        if (!$team instanceof Team) {
            $team = $this->teamManager->create($command->getTeamId(), $command->getTeamDomain());
        }

        return $team;
    }

}
