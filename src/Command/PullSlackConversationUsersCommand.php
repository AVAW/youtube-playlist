<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\Slack\Conversation\ConversationProvider;
use JoliCode\Slack\Api\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PullSlackConversationUsersCommand extends Command
{

    protected static $defaultName = 'app:pull-slack-conversation-users';
    protected static string $defaultDescription = 'Pull conversation users from Slack API';

    protected Client $client;
    protected ConversationProvider $conversationProvider;
    protected LoggerInterface $logger;

    public function __construct(
        Client $client,
        ConversationProvider $conversationProvider,
        LoggerInterface $logger,
        string $name = null
    ) {
        $this->client = $client;
        $this->conversationProvider = $conversationProvider;
        $this->logger = $logger;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // todo: add pagination
        $conversations = $this->conversationProvider->findAll();

        foreach ($conversations as $conversation) {
            try {
                $slackConversationMembers = $this->client->conversationsMembers(['channel' => $conversation->getConversationId()]);

                foreach ($slackConversationMembers->getMembers() as $userId) {
                    // todo: add users to app
                }
            } catch (\Throwable $e) {
                $this->logger->error($e->getMessage());
                $io->error($e->getMessage());
            }
        }

        $io->success('Done.');

        return Command::SUCCESS;
    }

}
