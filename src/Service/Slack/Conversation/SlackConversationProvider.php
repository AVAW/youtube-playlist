<?php

declare(strict_types=1);

namespace App\Service\Slack\Conversation;

use App\Entity\Slack\SlackConversation;
use App\Repository\Slack\SlackConversationRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class SlackConversationProvider
{

    protected SlackConversationRepository $repository;

    public function __construct(SlackConversationRepository $channelRepository)
    {
        $this->repository = $channelRepository;
    }

    /** @return SlackConversation[] */
    public function findAll(): iterable
    {
        return $this->repository->findAll();
    }

    public function findByConversationId(string $channelId): ?SlackConversation
    {
        return $this->repository->findOneBy(['conversationId' => $channelId]);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(SlackConversation $conversation)
    {
        $this->repository->save($conversation);
    }

    public function findByIdentifier(string $identifier): ?SlackConversation
    {
        try {
            return $this->repository->findOneBy(['identifier' => $identifier]);
        } catch (\Throwable $e) {
            return null;
        }
    }

}
