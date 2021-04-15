<?php

declare(strict_types=1);

namespace App\EventSubscriber\Command\Slack;

use App\Event\Slack\NewConversationEvent;
use App\Handler\Request\Slack\Conversation\ConversationUpdateRequestHandler;
use App\Handler\Request\Slack\User\UserCollectionGetOrCreateRequestHandler;
use App\Model\Slack\Conversation\ConversationUpdateRequest;
use App\Model\Slack\User\UserCollectionGetOrCreateRequest;
use JoliCode\Slack\Api\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NewConversationSubscriber implements EventSubscriberInterface
{

    private Client $client;
    private ConversationUpdateRequestHandler $conversationUpdateRequestHandler;
    private LoggerInterface $logger;
    private UserCollectionGetOrCreateRequestHandler $userCollectionGetOrCreateRequestHandler;

    public function __construct(
        Client $client,
        ConversationUpdateRequestHandler $conversationUpdateRequestHandler,
        LoggerInterface $logger,
        UserCollectionGetOrCreateRequestHandler $userCollectionGetOrCreateRequestHandler
    ) {
        $this->client = $client;
        $this->conversationUpdateRequestHandler = $conversationUpdateRequestHandler;
        $this->logger = $logger;
        $this->userCollectionGetOrCreateRequestHandler = $userCollectionGetOrCreateRequestHandler;
    }

    public function onNewConversationEvent(NewConversationEvent $event)
    {
        $conversation = $event->getConversation();

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
            $this->userCollectionGetOrCreateRequestHandler->handle($conversation, $command);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NewConversationEvent::class => 'onNewConversationEvent',
        ];
    }

}
