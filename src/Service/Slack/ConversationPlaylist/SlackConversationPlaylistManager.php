<?php

declare(strict_types=1);

namespace App\Service\Slack\ConversationPlaylist;

use App\Entity\Playlist\Playlist;
use App\Entity\Slack\SlackConversation;
use App\Entity\Slack\SlackConversationPlaylist;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Uid\UuidV4;

class SlackConversationPlaylistManager
{

    private SlackConversationPlaylistProvider $provider;

    public function __construct(
        SlackConversationPlaylistProvider $conversationPlaylistProvider
    ) {
        $this->provider = $conversationPlaylistProvider;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(
        Playlist $playlist,
        SlackConversation $conversation
    ): SlackConversationPlaylist {
        $conversationPlaylist = (new SlackConversationPlaylist())
            ->setPlaylist($playlist)
            ->setConversation($conversation)
            ->setIdentifier(UuidV4::v4());

        $this->provider->save($conversationPlaylist);

        return $conversationPlaylist;
    }

}
