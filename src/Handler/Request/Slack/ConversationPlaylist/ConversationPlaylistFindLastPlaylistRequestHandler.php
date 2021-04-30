<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\ConversationPlaylist;

use App\Entity\Playlist\Playlist;
use App\Entity\Slack\SlackConversationPlaylist;
use App\Service\Slack\ConversationPlaylist\SlackConversationPlaylistProvider;
use Doctrine\ORM\NonUniqueResultException;

class ConversationPlaylistFindLastPlaylistRequestHandler
{

    private SlackConversationPlaylistProvider $conversationPlaylistProvider;

    public function __construct(
        SlackConversationPlaylistProvider $conversationPlaylistProvider
    ) {
        $this->conversationPlaylistProvider = $conversationPlaylistProvider;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function handle(ConversationPlaylistFindLastPlaylistInterface $findLastPlaylist): ?Playlist
    {
        $conversationPlaylist = $this->conversationPlaylistProvider
            ->findLastConversationPlaylist($findLastPlaylist->getConversation());

        if ($conversationPlaylist instanceof SlackConversationPlaylist) {
            return $conversationPlaylist->getPlaylist();
        }

        return null;
    }

}
