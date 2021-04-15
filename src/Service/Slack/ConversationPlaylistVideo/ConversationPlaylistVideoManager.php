<?php

declare(strict_types=1);

namespace App\Service\Slack\ConversationPlaylistVideo;

use App\Entity\Playlist\PlaylistVideo;
use App\Entity\Slack\ConversationPlaylist;
use App\Entity\Slack\ConversationPlaylistVideo;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Uid\UuidV4;

class ConversationPlaylistVideoManager
{

    private ConversationPlaylistVideoProvider $provider;

    public function __construct(
        ConversationPlaylistVideoProvider $provider
    ) {
        $this->provider = $provider;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(
        ConversationPlaylist $conversationPlaylist,
        PlaylistVideo $playlistVideo
    ): ConversationPlaylistVideo {
        $conversationPlaylistVideo = (new ConversationPlaylistVideo())
            ->setConversationPlaylist($conversationPlaylist)
            ->setCurrentVideo($playlistVideo)
            ->setIdentifier(UuidV4::v4());

        $this->provider->save($conversationPlaylistVideo);

        return $conversationPlaylistVideo;
    }
}
