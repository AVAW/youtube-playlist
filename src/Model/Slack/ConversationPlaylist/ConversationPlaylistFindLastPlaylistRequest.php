<?php

declare(strict_types=1);

namespace App\Model\Slack\ConversationPlaylist;

use App\Entity\Slack\Conversation;
use App\Handler\Request\Slack\ConversationPlaylist\ConversationPlaylistFindLastPlaylistInterface;

class ConversationPlaylistFindLastPlaylistRequest implements ConversationPlaylistFindLastPlaylistInterface
{

    private Conversation $conversation;

    public static function create(Conversation $conversation): self
    {
        return (new static)
            ->setConversation($conversation);
    }

    public function getConversation(): Conversation
    {
        return $this->conversation;
    }

    public function setConversation(Conversation $conversation): self
    {
        $this->conversation = $conversation;

        return $this;
    }

}
