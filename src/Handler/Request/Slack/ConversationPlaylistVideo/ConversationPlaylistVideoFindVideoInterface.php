<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\ConversationPlaylistVideo;

use App\Entity\Slack\Conversation;

interface ConversationPlaylistVideoFindVideoInterface
{

    public function getConversation(): Conversation;

}
