<?php

declare(strict_types=1);

namespace App\EventSubscriber\Command\Slack;

use App\Event\Slack\TeamEvent;
use App\Handler\Request\Slack\Team\TeamUpdateRequestHandler;
use App\Model\Slack\Team\TeamUpdateRequest;
use JoliCode\Slack\Api\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TeamSubscriber implements EventSubscriberInterface
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

    public function onTeamEvent(TeamEvent $event)
    {
        $team = $event->getTeam();
        // todo: check last update time

        // Get team info
        try {
            $slackTeam = $this->client->teamInfo(['team' => $team->getTeamId()])->getTeam();

            $teamUpdateRequest = TeamUpdateRequest::createFromObjsTeam($slackTeam);
            $this->teamUpdateRequestHandler->handle($team, $teamUpdateRequest);

            $team->setName($slackTeam->getName());
            $team->setEmailDomain($slackTeam->getEmailDomain());
            $team->setIconUrl($slackTeam->getIcon()->getImage230());
            // todo: save team
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            TeamEvent::class => 'onTeamEvent',
        ];
    }

}
