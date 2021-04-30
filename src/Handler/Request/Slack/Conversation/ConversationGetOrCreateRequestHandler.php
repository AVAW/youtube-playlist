<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Conversation;

use App\Entity\Slack\SlackConversation;
use App\Message\Slack\NewSlackConversation;
use App\Service\Slack\Conversation\SlackConversationManager;
use App\Service\Slack\Conversation\SlackConversationProvider;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class ConversationGetOrCreateRequestHandler
{

    private EventDispatcherInterface $dispatcher;
    private SlackConversationManager $conversationManager;
    private SlackConversationProvider $conversationProvider;
    private LoggerInterface $infoLogger;
    private MessageBusInterface $bus;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        SlackConversationManager $conversationManager,
        SlackConversationProvider $conversationProvider,
        LoggerInterface $infoLogger,
        MessageBusInterface $bus
    ) {
        $this->dispatcher = $dispatcher;
        $this->conversationManager = $conversationManager;
        $this->conversationProvider = $conversationProvider;
        $this->infoLogger = $infoLogger;
        $this->bus = $bus;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle(ConversationGetOrCreateInterface $command): SlackConversation
    {
        $conversation = $this->conversationProvider->findByConversationId($command->getChannelId());
        if (!$conversation instanceof SlackConversation) {
            $conversation = $this->conversationManager->create($command->getChannelId(), $command->getChannelName());

            $this->bus->dispatch(new NewSlackConversation((string) $conversation->getIdentifier()));

            $this->infoLogger->info("New conversation. Name: {$conversation->getName()}");
        }

        return $conversation;
    }

}
