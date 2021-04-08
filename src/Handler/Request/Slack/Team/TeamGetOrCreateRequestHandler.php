<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Team;

use App\Entity\Slack\Team;
use App\Event\Slack\NewTeamEvent;
use App\Service\Slack\Team\TeamManager;
use App\Service\Slack\Team\TeamProvider;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class TeamGetOrCreateRequestHandler
{

    private EventDispatcherInterface $dispatcher;
    private TeamManager $teamManager;
    private TeamProvider $teamProvider;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        TeamManager $teamManager,
        TeamProvider $teamProvider
    ) {
        $this->dispatcher = $dispatcher;
        $this->teamManager = $teamManager;
        $this->teamProvider = $teamProvider;
    }

    public function handle(TeamGetOrCreateInterface $command): Team
    {
        $team = $this->teamProvider->findOneByTeamId($command->getTeamId());
        if (!$team instanceof Team) {
            $team = $this->teamManager->create($command->getTeamId(), $command->getTeamDomain());

            $this->dispatcher->dispatch(new NewTeamEvent($team));
        }

        return $team;
    }

}
