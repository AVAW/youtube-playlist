<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Team;

use App\Entity\Slack\SlackTeam;
use App\Service\Slack\Team\SlackTeamManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class TeamUpdateRequestHandler
{

    private SlackTeamManager $teamManager;

    public function __construct(
        SlackTeamManager $teamManager
    ) {
        $this->teamManager = $teamManager;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle(SlackTeam $team, TeamUpdateInterface $command)
    {
        $this->teamManager->update(
            $team,
            $command->getName(),
            $command->getEmailDomain(),
            $command->getIconUrl(),
        );
    }

}
