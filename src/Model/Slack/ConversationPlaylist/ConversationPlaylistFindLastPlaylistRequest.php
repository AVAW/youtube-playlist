<?php

declare(strict_types=1);

namespace App\Model\Slack\ConversationPlaylist;

use App\Entity\Slack\SlackConversation;
use App\Handler\Request\Slack\ConversationPlaylist\ConversationPlaylistFindLastPlaylistInterface;

class ConversationPlaylistFindLastPlaylistRequest implements ConversationPlaylistFindLastPlaylistInterface
{

    private SlackConversation $conversation;

    public static function create(SlackConversation $conversation): self
    {
        return (new static)
            ->setConversation($conversation);
    }

    public function getConversation(): SlackConversation
    {
        return $this->conversation;
    }

    public function setConversation(SlackConversation $conversation): self
    {
        $this->conversation = $conversation;

        return $this;
    }

}
