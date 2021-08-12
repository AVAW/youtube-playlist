<?php

declare(strict_types=1);

namespace App\Service\Slack\ConversationPlaylist;

use App\Entity\Playlist\Playlist;
use App\Entity\Slack\SlackConversation;
use App\Entity\Slack\SlackConversationPlaylist;
use App\Repository\Slack\SlackConversationPlaylistRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Throwable;

class SlackConversationPlaylistProvider
{

    private SlackConversationPlaylistRepository $repository;

    public function __construct(
        SlackConversationPlaylistRepository $conversationPlaylistRepository
    ) {
        $this->repository = $conversationPlaylistRepository;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(SlackConversationPlaylist $conversationPlaylist)
    {
        $this->repository->save($conversationPlaylist);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findLastConversationPlaylist(SlackConversation $conversation): ?SlackConversationPlaylist
    {
        return $this->repository->findLastConversationPlaylist($conversation);
    }

    public function findByIdentifier(string $identifier): ?SlackConversationPlaylist
    {
        try {
            return $this->repository->findOneBy(['identifier' => $identifier]);
        } catch (Throwable $e) {
            return null;
        }
    }

    public function findByPlaylist(Playlist $playlist): ?SlackConversationPlaylist
    {
        return $this->repository->findOneBy(['playlist' => $playlist]);
    }

}
