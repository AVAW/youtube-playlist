<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\ConversationPlaylist;

use App\Entity\Slack\Conversation;

interface ConversationPlaylistFindLastPlaylistInterface
{

    public function getConversation(): Conversation;

}
