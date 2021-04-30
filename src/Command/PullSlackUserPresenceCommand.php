<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Slack\SlackUserPresence;
use App\Handler\Request\Slack\UserPresence\UserPresenceCreateOrUpdateRequestHandler;
use App\Model\Slack\UserPresence\UserPresenceCreateOrUpdateRequest;
use App\Service\Slack\User\SlackUserProvider;
use App\Utils\Timestampable\TimestampableHelper;
use JoliCode\Slack\Api\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PullSlackUserPresenceCommand extends Command
{

    /** @var string */
    protected static $defaultName = 'app:pull-slack-user-presence';
    protected static string $defaultDescription = 'Pull all users presence from Slack API';

    protected Client $client;
    protected LoggerInterface $logger;
    protected UserPresenceCreateOrUpdateRequestHandler $userPresenceCreateOrUpdateRequestHandler;
    protected SlackUserProvider $userProvider;

    public function __construct(
        Client $client,
        LoggerInterface $logger,
        UserPresenceCreateOrUpdateRequestHandler $userPresenceCreateOrUpdateRequestHandler,
        SlackUserProvider $userProvider,
        string $name = null
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->userPresenceCreateOrUpdateRequestHandler = $userPresenceCreateOrUpdateRequestHandler;
        $this->userProvider = $userProvider;
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
        $users = $this->userProvider->findAll();

        foreach ($users as $user) {
            if ($user->getPresence() instanceof SlackUserPresence
                && TimestampableHelper::isUpdatedInLastXMinutes($user->getPresence(), 5)
            ) {
                continue;
            }
            try {
                $slackPresence = $this->client->usersGetPresence(['user' => $user->getProfileId()]);
                $command = UserPresenceCreateOrUpdateRequest::createFromUserPresence($slackPresence);
                $this->userPresenceCreateOrUpdateRequestHandler->handle($user, $command);
            } catch (\Throwable $e) {
                $this->logger->error($e->getMessage());
                $io->error($e->getMessage());
            }
        }

        $io->success('Done.');

        return Command::SUCCESS;
    }

}
