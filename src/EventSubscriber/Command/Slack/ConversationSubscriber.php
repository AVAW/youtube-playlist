<?php

declare(strict_types=1);

namespace App\EventSubscriber\Command\Slack;

use App\Entity\Slack\UserPresence;
use App\Event\Slack\ConversationEvent;
use App\Handler\Request\Slack\Conversation\ConversationUpdateRequestHandler;
use App\Handler\Request\Slack\User\UserUpdateOrCreateRequestHandler;
use App\Handler\Request\Slack\UserPresence\UserPresenceCreateOrUpdateRequestHandler;
use App\Model\Slack\Conversation\ConversationUpdateRequest;
use App\Model\Slack\User\UserUpdateOrCreateRequest;
use App\Model\Slack\UserPresence\UserPresenceCreateOrUpdateRequest;
use App\Utils\LastUpdateHelper;
use JoliCode\Slack\Api\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConversationSubscriber implements EventSubscriberInterface
{

    private ConversationUpdateRequestHandler $conversationUpdateRequestHandler;
    private Client $client;
    private LoggerInterface $logger;
    private UserUpdateOrCreateRequestHandler $userCreateFullRequestHandler;
    private UserPresenceCreateOrUpdateRequestHandler $userPresenceCreateOrUpdateRequestHandler;

    public function __construct(
        ConversationUpdateRequestHandler $conversationUpdateRequestHandler,
        Client $client,
        LoggerInterface $logger,
        UserUpdateOrCreateRequestHandler $userCreateFullRequestHandler,
        UserPresenceCreateOrUpdateRequestHandler $userPresenceCreateOrUpdateRequestHandler
    ) {
        $this->conversationUpdateRequestHandler = $conversationUpdateRequestHandler;
        $this->client = $client;
        $this->logger = $logger;
        $this->userCreateFullRequestHandler = $userCreateFullRequestHandler;
        $this->userPresenceCreateOrUpdateRequestHandler = $userPresenceCreateOrUpdateRequestHandler;
    }

    public function onChannelEvent(ConversationEvent $event)
    {
        $conversation = $event->getConversation();

        // Get conversation data
        if (!LastUpdateHelper::isUpdatedInLastXMinutes($conversation, 10)) {
            try {
                $slackChannel = $this->client->conversationsInfo(['channel' => $conversation->getConversationId()])->getChannel();
                $conversationUpdateRequest = ConversationUpdateRequest::createFromObjConversation($slackChannel);
                $this->conversationUpdateRequestHandler->handle($conversation, $conversationUpdateRequest);
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
            }
        }

        try {
            // todo: move it to cron command
            $slackConversationMembers = $this->client->conversationsMembers(['channel' => $conversation->getConversationId()]);

            foreach ($slackConversationMembers->getMembers() as $userId) {
                $slackUser = $this->client->usersInfo(['user' => $userId])->getUser();
                if ($slackUser->getIsBot()) {
                    continue;
                }

                $userCreateRequest = UserUpdateOrCreateRequest::createFromObjsUser($slackUser);
                $userCreateRequest->setChannelId($conversation->getConversationId());
                $this->userCreateFullRequestHandler->handle($userCreateRequest);
            }
            // todo: implement next page cursor
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        // Get presence of channel users
        foreach ($conversation->getUsers() as $user) {
            if ($user->getPresence() instanceof UserPresence
                && LastUpdateHelper::isUpdatedInLastXMinutes($user->getPresence(), 5)
            ) {
                continue;
            }
            try {
                $presence = $this->client->usersGetPresence(['user' => $user->getUserId()]);
                $userPresenceRequest = UserPresenceCreateOrUpdateRequest::createFromUserPresence($presence);
                $this->userPresenceCreateOrUpdateRequestHandler->handle($user, $userPresenceRequest);
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ConversationEvent::class => 'onChannelEvent',
        ];
    }

}
