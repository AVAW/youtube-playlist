<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\ConversationPlaylist;

use App\Entity\Slack\ConversationPlaylist;
use App\Service\Slack\ConversationPlaylist\ConversationPlaylistManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ConversationPlaylistCreateRequestHandler
{

    private ConversationPlaylistManager $conversationPlaylistManager;

    public function __construct(
        ConversationPlaylistManager $conversationPlaylistManager
    ) {
        $this->conversationPlaylistManager = $conversationPlaylistManager;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle(ConversationPlaylistCreateInterface $conversationPlaylistCreateRequest): ConversationPlaylist
    {
        return $this->conversationPlaylistManager->create(
            $conversationPlaylistCreateRequest->getPlaylist(),
            $conversationPlaylistCreateRequest->getConversation(),
        );
    }

}
