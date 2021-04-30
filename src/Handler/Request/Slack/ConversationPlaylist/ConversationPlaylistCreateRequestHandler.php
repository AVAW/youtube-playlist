<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\ConversationPlaylist;

use App\Entity\Slack\SlackConversationPlaylist;
use App\Service\Slack\ConversationPlaylist\SlackConversationPlaylistManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ConversationPlaylistCreateRequestHandler
{

    private SlackConversationPlaylistManager $conversationPlaylistManager;

    public function __construct(
        SlackConversationPlaylistManager $conversationPlaylistManager
    ) {
        $this->conversationPlaylistManager = $conversationPlaylistManager;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle(ConversationPlaylistCreateInterface $conversationPlaylistCreateRequest): SlackConversationPlaylist
    {
        return $this->conversationPlaylistManager->create(
            $conversationPlaylistCreateRequest->getPlaylist(),
            $conversationPlaylistCreateRequest->getConversation(),
        );
    }

}
