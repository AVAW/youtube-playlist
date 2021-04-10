<?php

declare(strict_types=1);

namespace App\Service\Slack\ConversationPlaylist;

use App\Entity\Slack\ConversationPlaylist;
use App\Repository\Slack\ConversationPlaylistRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ConversationPlaylistProvider
{

    private ConversationPlaylistRepository $repository;

    public function __construct(
        ConversationPlaylistRepository $conversationPlaylistRepository
    ) {
        $this->repository = $conversationPlaylistRepository;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(ConversationPlaylist $conversationPlaylist)
    {
        $this->repository->save($conversationPlaylist);
    }


}
