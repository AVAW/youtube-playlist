<?php

declare(strict_types=1);

namespace App\EventSubscriber\Command\Slack;

use App\Event\Slack\NewTeamEvent;
use App\Handler\Request\Slack\Team\TeamUpdateRequestHandler;
use App\Model\Slack\Team\TeamUpdateRequest;
use JoliCode\Slack\Api\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NewTeamSubscriber implements EventSubscriberInterface
{

    private TeamUpdateRequestHandler $teamUpdateRequestHandler;
    private Client $client;
    private LoggerInterface $logger;

    public function __construct(
        TeamUpdateRequestHandler $teamUpdateRequestHandler,
        Client $client,
        LoggerInterface $logger
    ) {
        $this->teamUpdateRequestHandler = $teamUpdateRequestHandler;
        $this->client = $client;
        $this->logger = $logger;
    }

    public function onNewTeamEvent(NewTeamEvent $event)
    {
        $team = $event->getTeam();

        // Get team data
        try {
            $slackTeam = $this->client->teamInfo(['team' => $team->getTeamId()])->getTeam();
            $command = TeamUpdateRequest::createFromObjsTeam($slackTeam);
            $this->teamUpdateRequestHandler->handle($team, $command);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NewTeamEvent::class => 'onNewTeamEvent',
        ];
    }

}
