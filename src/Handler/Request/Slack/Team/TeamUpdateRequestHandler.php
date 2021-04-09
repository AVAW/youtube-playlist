<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Team;

use App\Entity\Slack\Team;
use App\Service\Slack\Team\TeamManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class TeamUpdateRequestHandler
{

    private TeamManager $teamManager;

    public function __construct(
        TeamManager $teamManager
    ) {
        $this->teamManager = $teamManager;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle(Team $team, TeamUpdateInterface $command)
    {
        $this->teamManager->update(
            $team,
            $command->getName(),
            $command->getEmailDomain(),
            $command->getIconUrl(),
        );
    }

}
