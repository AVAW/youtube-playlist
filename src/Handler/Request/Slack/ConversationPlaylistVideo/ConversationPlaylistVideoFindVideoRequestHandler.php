<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\ConversationPlaylistVideo;

use App\Entity\Slack\ConversationPlaylistVideo;
use App\Service\Slack\ConversationPlaylistVideo\ConversationPlaylistVideoProvider;

class ConversationPlaylistVideoFindVideoRequestHandler
{

    private ConversationPlaylistVideoProvider $conversationPlaylistVideoProvider;

    public function __construct(
        ConversationPlaylistVideoProvider $conversationPlaylistVideoProvider
    ) {
        $this->conversationPlaylistVideoProvider = $conversationPlaylistVideoProvider;
    }

    public function handle(ConversationPlaylistVideoFindVideoInterface $findPlayedVideo): ?ConversationPlaylistVideo
    {
        return $this->conversationPlaylistVideoProvider->findLastConversationPlaylistVideo($findPlayedVideo->getConversation());
    }

}
