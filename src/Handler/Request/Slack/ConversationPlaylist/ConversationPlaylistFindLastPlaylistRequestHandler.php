<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\ConversationPlaylist;

use App\Entity\Playlist\Playlist;
use App\Entity\Slack\ConversationPlaylist;
use App\Service\Slack\ConversationPlaylist\ConversationPlaylistProvider;
use Doctrine\ORM\NonUniqueResultException;

class ConversationPlaylistFindLastPlaylistRequestHandler
{

    private ConversationPlaylistProvider $conversationPlaylistProvider;

    public function __construct(
        ConversationPlaylistProvider $conversationPlaylistProvider
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

        if ($conversationPlaylist instanceof ConversationPlaylist) {
            return $conversationPlaylist->getPlaylist();
        }

        return null;
    }

}
