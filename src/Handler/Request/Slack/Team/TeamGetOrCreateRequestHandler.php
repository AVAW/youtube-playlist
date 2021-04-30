<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Team;

use App\Entity\Slack\SlackTeam;
use App\Event\Slack\NewSlackTeamEvent;
use App\Message\Slack\NewSlackTeam;
use App\Service\Slack\Team\SlackTeamManager;
use App\Service\Slack\Team\SlackTeamProvider;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class TeamGetOrCreateRequestHandler
{

    private EventDispatcherInterface $dispatcher;
    private LoggerInterface $infoLogger;
    private SlackTeamManager $teamManager;
    private SlackTeamProvider $teamProvider;
    private MessageBusInterface $bus;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        LoggerInterface $infoLogger,
        SlackTeamManager $teamManager,
        SlackTeamProvider $teamProvider,
        MessageBusInterface $bus
    ) {
        $this->dispatcher = $dispatcher;
        $this->infoLogger =$infoLogger;
        $this->teamManager = $teamManager;
        $this->teamProvider = $teamProvider;
        $this->bus = $bus;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle(TeamGetOrCreateInterface $command): SlackTeam
    {
        $team = $this->teamProvider->findOneByTeamId($command->getTeamId());
        if (!$team instanceof SlackTeam) {
            $team = $this->teamManager->create(
                $command->getTeamId(),
                $command->getTeamDomain()
            );

            $this->bus->dispatch(new NewSlackTeam((string) $team->getIdentifier()));

            $this->infoLogger->info("New team. Domain: {$team->getDomain()}");
        }

        return $team;
    }

}
