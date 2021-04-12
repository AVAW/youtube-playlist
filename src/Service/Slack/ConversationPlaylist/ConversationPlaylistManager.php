<?php

declare(strict_types=1);

namespace App\Service\Slack\ConversationPlaylist;

use App\Entity\Playlist\Playlist;
use App\Entity\Slack\Conversation;
use App\Entity\Slack\ConversationPlaylist;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Uid\UuidV4;

class ConversationPlaylistManager
{

    private ConversationPlaylistProvider $provider;

    public function __construct(
        ConversationPlaylistProvider $conversationPlaylistProvider
    ) {
        $this->provider = $conversationPlaylistProvider;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(
        Playlist $playlist,
        Conversation $conversation
    ): ConversationPlaylist {
        $conversationPlaylist = (new ConversationPlaylist())
            ->setPlaylist($playlist)
            ->setConversation($conversation)
            ->setIdentifier(UuidV4::v4());

        $this->provider->save($conversationPlaylist);

        return $conversationPlaylist;
    }

}
