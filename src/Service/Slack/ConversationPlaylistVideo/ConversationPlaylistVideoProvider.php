<?php

declare(strict_types=1);

namespace App\Service\Slack\ConversationPlaylistVideo;

use App\Entity\Playlist\PlaylistVideo;
use App\Entity\Slack\Conversation;
use App\Entity\Slack\ConversationPlaylist;
use App\Entity\Slack\ConversationPlaylistVideo;
use App\Repository\Slack\ConversationPlaylistVideoRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ConversationPlaylistVideoProvider
{

    private ConversationPlaylistVideoRepository $repository;

    public function __construct(
        ConversationPlaylistVideoRepository $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(ConversationPlaylistVideo $conversationPlaylist)
    {
        $this->repository->save($conversationPlaylist);
    }

    public function findLastConversationPlaylistVideo(Conversation $conversation): ConversationPlaylistVideo
    {
        return $this->repository->findLastConversationPlaylistVideo($conversation);
    }

}
