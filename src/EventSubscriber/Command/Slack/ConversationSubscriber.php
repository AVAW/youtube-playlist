<?php

declare(strict_types=1);

namespace App\EventSubscriber\Command\Slack;

use App\Event\Slack\ConversationEvent;
use JoliCode\Slack\Api\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConversationSubscriber implements EventSubscriberInterface
{

    private Client $client;
    private LoggerInterface $logger;

    public function __construct(
        Client $client,
        LoggerInterface $logger
    ) {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function onConversationEvent(ConversationEvent $event)
    {
        $conversation = $event->getConversation();

        // Run commands from here when conversation is fresh?
        // todo: Get conversation info
        // todo: Get conversation members
        // todo: Get members status
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ConversationEvent::class => 'onConversationEvent',
        ];
    }

}
