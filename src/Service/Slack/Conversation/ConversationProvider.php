<?php

declare(strict_types=1);

namespace App\Service\Slack\Conversation;

use App\Entity\Slack\Conversation;
use App\Repository\Slack\ConversationRepository;

class ConversationProvider
{

    protected ConversationRepository $repository;

    public function __construct(ConversationRepository $channelRepository)
    {
        $this->repository = $channelRepository;
    }

    /** @return Conversation[] */
    public function findAll(): iterable
    {
        return $this->repository->findAll();
    }

    public function findByConversationId(string $channelId): ?Conversation
    {
        return $this->repository->findOneBy(['conversationId' => $channelId]);
    }

    public function save(Conversation $conversation)
    {
        $this->repository->save($conversation);
    }

}
