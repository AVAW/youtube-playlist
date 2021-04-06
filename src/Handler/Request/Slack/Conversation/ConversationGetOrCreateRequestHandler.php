<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Conversation;

use App\Entity\Slack\Conversation;
use App\Service\Slack\Conversation\ConversationManager;
use App\Service\Slack\Conversation\ConversationProvider;

class ConversationGetOrCreateRequestHandler
{

    private ConversationManager $conversationManager;
    private ConversationProvider $conversationProvider;

    public function __construct(
        ConversationManager $conversationManager,
        ConversationProvider $conversationProvider
    ) {
        $this->conversationManager = $conversationManager;
        $this->conversationProvider = $conversationProvider;
    }

    public function handle(ConversationGetOrCreateInterface $command): Conversation
    {
        $conversation = $this->conversationProvider->findByConversationId($command->getChannelId());
        if (!$conversation instanceof Conversation) {
            $conversation = $this->conversationManager->create($command->getChannelId(), $command->getChannelName());
        }

        return $conversation;
    }

}
