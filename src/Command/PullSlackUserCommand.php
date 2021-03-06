<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Slack\SlackUser;
use App\Handler\Request\Slack\User\UserUpdateRequestHandler;
use App\Model\Slack\User\UserUpdateRequest;
use App\Service\Slack\User\SlackUserProvider;
use App\Utils\Timestampable\TimestampableHelper;
use JoliCode\Slack\Api\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PullSlackUserCommand extends Command
{

    /** @var string */
    protected static $defaultName = 'app:pull-slack-user';
    protected static string $defaultDescription = 'Pull all users data from Slack API';

    protected Client $client;
    protected LoggerInterface $logger;
    protected UserUpdateRequestHandler $userUpdateRequestHandler;
    protected SlackUserProvider $userProvider;

    public function __construct(
        Client $client,
        LoggerInterface $logger,
        UserUpdateRequestHandler $userUpdateRequestHandler,
        SlackUserProvider $userProvider,
        string $name = null
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->userUpdateRequestHandler = $userUpdateRequestHandler;
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
        /** @var SlackUser[] $users */
        $users = $this->userProvider->findAll();

        foreach ($users as $user) {
            if (TimestampableHelper::isUpdatedInLastXMinutes($user, 60)) {
                continue;
            }
            try {
                $slackUser = $this->client->usersInfo(['user' => $user->getProfileId()])->getUser();
                $command = UserUpdateRequest::createFromObjsUser($slackUser);
                $this->userUpdateRequestHandler->handle($user, $command);

                // todo: implement next page cursor

            } catch (\Throwable $e) {
                $this->logger->error($e->getMessage());
                $io->error($e->getMessage());
            }
        }

        $io->success('Done.');

        return Command::SUCCESS;
    }

}
