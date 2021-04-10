<?php

declare(strict_types=1);

namespace App\Model\Slack\ConversationPlaylist;

use App\Entity\Playlist\Playlist;
use App\Entity\Slack\Conversation;
use App\Handler\Request\Slack\ConversationPlaylist\ConversationPlaylistCreateInterface;

class ConversationPlaylistCreateRequest implements ConversationPlaylistCreateInterface
{

    private Playlist $playlist;
    private Conversation $conversation;

    public static function create(Playlist $playlist, Conversation $conversation): self
    {
        return (new static)
            ->setPlaylist($playlist)
            ->setConversation($conversation);
    }

    public function getPlaylist(): Playlist
    {
        return $this->playlist;
    }

    public function setPlaylist(Playlist $playlist): self
    {
        $this->playlist = $playlist;

        return $this;
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
