<?php

declare(strict_types=1);

namespace App\Model\Slack\ConversationPlaylistVideo;

use App\Entity\Slack\Conversation;
use App\Handler\Request\Slack\ConversationPlaylistVideo\ConversationPlaylistVideoFindVideoInterface;

class ConversationPlaylistVideoFindVideoRequest implements ConversationPlaylistVideoFindVideoInterface
{

    private Conversation $conversation;

    public static function create(\App\Entity\Slack\Conversation $conversation): self
    {
        return (new static)
            ->setConversation($conversation);
    }

    public function getConversation(): Conversation
    {
        return $this->conversation;
    }

    public function setConversation($conversation): self
    {
        $this->conversation = $conversation;

        return $this;
    }

}
