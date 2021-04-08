<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Conversation;

use App\Entity\Slack\Conversation;
use App\Event\Slack\NewConversationEvent;
use App\Service\Slack\Conversation\ConversationManager;
use App\Service\Slack\Conversation\ConversationProvider;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class ConversationGetOrCreateRequestHandler
{

    private EventDispatcherInterface $dispatcher;
    private ConversationManager $conversationManager;
    private ConversationProvider $conversationProvider;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        ConversationManager $conversationManager,
        ConversationProvider $conversationProvider
    ) {
        $this->dispatcher = $dispatcher;
        $this->conversationManager = $conversationManager;
        $this->conversationProvider = $conversationProvider;
    }

    public function handle(ConversationGetOrCreateInterface $command): Conversation
    {
        $conversation = $this->conversationProvider->findByConversationId($command->getChannelId());
        if (!$conversation instanceof Conversation) {
            $conversation = $this->conversationManager->create($command->getChannelId(), $command->getChannelName());

            $this->dispatcher->dispatch(new NewConversationEvent($conversation));
        }

        return $conversation;
    }

}
