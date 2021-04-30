<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\ConversationPlaylist;

use App\Entity\Slack\SlackConversation;

interface ConversationPlaylistFindLastPlaylistInterface
{

    public function getConversation(): SlackConversation;

}
