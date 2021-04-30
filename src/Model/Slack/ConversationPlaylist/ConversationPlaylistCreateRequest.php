<?php

declare(strict_types=1);

namespace App\Model\Slack\ConversationPlaylist;

use App\Entity\Playlist\Playlist;
use App\Entity\Slack\SlackConversation;
use App\Handler\Request\Slack\ConversationPlaylist\ConversationPlaylistCreateInterface;

class ConversationPlaylistCreateRequest implements ConversationPlaylistCreateInterface
{

    private Playlist $playlist;
    private SlackConversation $conversation;

    public static function create(Playlist $playlist, SlackConversation $conversation): self
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
