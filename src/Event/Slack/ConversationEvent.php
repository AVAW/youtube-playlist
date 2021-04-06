<?php

declare(strict_types=1);

namespace App\Event\Slack;

use App\Entity\Slack\Conversation;
use Symfony\Contracts\EventDispatcher\Event;

class ConversationEvent extends Event
{

    private Conversation $conversation;

    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }

    public function getConversation(): Conversation
    {
        return $this->conversation;
    }

}
