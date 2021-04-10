<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\ConversationPlaylist;

use App\Entity\Playlist\Playlist;
use App\Entity\Slack\Conversation;

interface ConversationPlaylistCreateInterface
{

    public function getPlaylist(): Playlist;

    public function getConversation(): Conversation;

}
