<?php

declare(strict_types=1);

namespace App\Command;

use App\Handler\Request\Slack\Conversation\ConversationUpdateRequestHandler;
use App\Model\Slack\Conversation\ConversationUpdateRequest;
use App\Service\Slack\Conversation\ConversationProvider;
use App\Utils\Timestampable\TimestampableHelper;
use JoliCode\Slack\Api\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PullSlackConversationCommand extends Command
{

    /** @var string */
    protected static $defaultName = 'app:pull-slack-conversation';
    protected static string $defaultDescription = 'Pull conversation info from slack API';

    protected Client $client;
    protected ConversationUpdateRequestHandler $conversationUpdateRequestHandler;
    protected LoggerInterface $logger;
    protected ConversationProvider $conversationProvider;

    public function __construct(
        Client $client,
        ConversationProvider $conversationProvider,
        ConversationUpdateRequestHandler $conversationUpdateRequestHandler,
        LoggerInterface $logger,
        string $name = null
    ) {
        $this->client = $client;
        $this->conversationProvider = $conversationProvider;
        $this->conversationUpdateRequestHandler = $conversationUpdateRequestHandler;
        $this->logger = $logger;
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
        $conversations = $this->conversationProvider->findAll();

        foreach ($conversations as $conversation) {
            if (TimestampableHelper::isUpdatedInLastXMinutes($conversation, 1)) {
                continue;
            }

            try {
                $slackChannel = $this->client->conversationsInfo(['channel' => $conversation->getConversationId()])->getChannel();
                $command = ConversationUpdateRequest::createFromObjConversation($slackChannel);
                $this->conversationUpdateRequestHandler->handle($conversation, $command);
            } catch (\Throwable $e) {
                $this->logger->error($e->getMessage());
                $io->error($e->getMessage());
            }
        }

        $io->success('Done.');

        return Command::SUCCESS;
    }

}
