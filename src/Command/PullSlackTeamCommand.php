<?php

declare(strict_types=1);

namespace App\Command;

use App\Handler\Request\Slack\Team\TeamUpdateRequestHandler;
use App\Model\Slack\Team\TeamUpdateRequest;
use App\Service\Slack\Team\TeamProvider;
use App\Utils\Timestampable\TimestampableHelper;
use JoliCode\Slack\Api\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PullSlackTeamCommand extends Command
{

    /** @var string */
    protected static $defaultName = 'app:pull-slack-team';
    protected static $defaultDescription = 'Add a short description for your command';

    protected Client $client;
    protected LoggerInterface $logger;
    protected TeamProvider $teamProvider;
    protected TeamUpdateRequestHandler $teamUpdateRequestHandler;

    public function __construct(
        Client $client,
        LoggerInterface $logger,
        TeamProvider $teamProvider,
        TeamUpdateRequestHandler $teamUpdateRequestHandler,
        string $name = null
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->teamProvider = $teamProvider;
        $this->teamUpdateRequestHandler = $teamUpdateRequestHandler;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // todo: add pagination
        $teams = $this->teamProvider->findAll();

        foreach ($teams as $team) {
            if (TimestampableHelper::isUpdatedInLastXMinutes($team, 10)) {
                continue;
            }
            try {
                $slackTeam = $this->client->teamInfo(['team' => $team->getTeamId()])->getTeam();
                $command = TeamUpdateRequest::createFromObjsTeam($slackTeam);
                $this->teamUpdateRequestHandler->handle($team, $command);
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                $io->error($e->getMessage());
            }
        }

        $io->success('Done.');

        return Command::SUCCESS;
    }

}
