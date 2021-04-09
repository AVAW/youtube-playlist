<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Team;

use App\Entity\Slack\Team;
use App\Event\Slack\NewTeamEvent;
use App\Service\Slack\Team\TeamManager;
use App\Service\Slack\Team\TeamProvider;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class TeamGetOrCreateRequestHandler
{

    private EventDispatcherInterface $dispatcher;
    private LoggerInterface $infoLogger;
    private TeamManager $teamManager;
    private TeamProvider $teamProvider;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        LoggerInterface $infoLogger,
        TeamManager $teamManager,
        TeamProvider $teamProvider
    ) {
        $this->dispatcher = $dispatcher;
        $this->infoLogger =$infoLogger;
        $this->teamManager = $teamManager;
        $this->teamProvider = $teamProvider;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle(TeamGetOrCreateInterface $command): Team
    {
        $team = $this->teamProvider->findOneByTeamId($command->getTeamId());
        if (!$team instanceof Team) {
            $team = $this->teamManager->create(
                $command->getTeamId(),
                $command->getTeamDomain()
            );

            $this->dispatcher->dispatch(new NewTeamEvent($team));
            $this->infoLogger->info("New team, domain: {$team->getDomain()}");
        }

        return $team;
    }

}
