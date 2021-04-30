<?php

declare(strict_types=1);

namespace App\Handler\Message\Slack;

use App\Entity\Slack\SlackConversation;
use App\Handler\Request\Slack\Conversation\ConversationUpdateRequestHandler;
use App\Handler\Request\Slack\User\UserCollectionGetOrCreateRequestHandler;
use App\Message\Slack\NewSlackConversation;
use App\Model\Slack\Conversation\ConversationUpdateRequest;
use App\Model\Slack\User\UserCollectionGetOrCreateRequest;
use App\Service\Slack\Conversation\SlackConversationProvider;
use JoliCode\Slack\Api\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class NewSlackConversationHandler implements MessageHandlerInterface
{

    private Client $client;
    private ConversationUpdateRequestHandler $conversationUpdateRequestHandler;
    private LoggerInterface $logger;
    private UserCollectionGetOrCreateRequestHandler $userCollectionGetOrCreateRequestHandler;
    private SlackConversationProvider $slackConversationProvider;

    public function __construct(
        Client $client,
        ConversationUpdateRequestHandler $conversationUpdateRequestHandler,
        LoggerInterface $logger,
        UserCollectionGetOrCreateRequestHandler $userCollectionGetOrCreateRequestHandler,
        SlackConversationProvider $slackConversationProvider
    ) {
        $this->client = $client;
        $this->conversationUpdateRequestHandler = $conversationUpdateRequestHandler;
        $this->logger = $logger;
        $this->userCollectionGetOrCreateRequestHandler = $userCollectionGetOrCreateRequestHandler;
        $this->slackConversationProvider = $slackConversationProvider;
    }

    public function __invoke(NewSlackConversation $conversation)
    {
        $conversation = $this->slackConversationProvider->findByIdentifier($conversation->getIdentifier());
        if (!$conversation instanceof SlackConversation) {
            return;
        }

        try {
            $slackChannel = $this->client->conversationsInfo(['channel' => $conversation->getConversationId(), 'include_locale' => true])->getChannel();
            $command = ConversationUpdateRequest::createFromObjConversation($slackChannel);
            $this->conversationUpdateRequestHandler->handle($conversation, $command);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }

        try {
            $slackConversationMembers = $this->client->conversationsMembers(['channel' => $conversation->getConversationId()]);
            $command = UserCollectionGetOrCreateRequest::createFromArray($slackConversationMembers->getMembers());
            $this->userCollectionGetOrCreateRequestHandler->handle($command, $conversation);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }
    }

}
