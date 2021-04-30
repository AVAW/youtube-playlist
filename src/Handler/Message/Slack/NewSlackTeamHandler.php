<?php

declare(strict_types=1);

namespace App\Handler\Message\Slack;

use App\Entity\Slack\SlackTeam;
use App\Handler\Request\Slack\Team\TeamUpdateRequestHandler;
use App\Message\Slack\NewSlackTeam;
use App\Model\Slack\Team\TeamUpdateRequest;
use App\Service\Slack\Team\SlackTeamProvider;
use JoliCode\Slack\Api\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class NewSlackTeamHandler implements MessageHandlerInterface
{

    private TeamUpdateRequestHandler $teamUpdateRequestHandler;
    private SlackTeamProvider $slackTeamProvider;
    private Client $client;
    private LoggerInterface $logger;

    public function __construct(
        TeamUpdateRequestHandler $teamUpdateRequestHandler,
        SlackTeamProvider $slackTeamProvider,
        Client $client,
        LoggerInterface $logger
    ) {
        $this->teamUpdateRequestHandler = $teamUpdateRequestHandler;
        $this->slackTeamProvider = $slackTeamProvider;
        $this->client = $client;
        $this->logger = $logger;
    }

    public function __invoke(NewSlackTeam $team)
    {
        $team = $this->slackTeamProvider->findByIdentifier($team->getIdentifier());
        if (!$team instanceof SlackTeam) {
            return;
        }

        // Get team data
        try {
            $slackTeam = $this->client->teamInfo(['team' => $team->getTeamId()])->getTeam();
            $command = TeamUpdateRequest::createFromObjsTeam($slackTeam);
            $this->teamUpdateRequestHandler->handle($team, $command);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }

    }

}
