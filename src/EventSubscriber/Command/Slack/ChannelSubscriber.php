<?php

declare(strict_types=1);

namespace App\EventSubscriber\Command\Slack;

use App\Entity\Slack\UserPresence;
use App\Event\Slack\ChannelEvent;
use App\Handler\Request\Slack\User\UserCreateRequestHandler;
use App\Handler\Request\Slack\UserPresence\UserPresenceCreateOrUpdateRequestHandler;
use App\Model\Slack\User\UserCreateRequest;
use App\Model\Slack\UserPresence\UserPresenceCreateOrUpdateRequest;
use JoliCode\Slack\Api\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ChannelSubscriber implements EventSubscriberInterface
{

    private Client $client;
    private LoggerInterface $logger;
    private UserCreateRequestHandler $userCreateFullRequestHandler;
    private UserPresenceCreateOrUpdateRequestHandler $userPresenceCreateOrUpdateRequestHandler;

    public function __construct(
        Client $client,
        LoggerInterface $logger,
        UserCreateRequestHandler $userCreateFullRequestHandler,
        UserPresenceCreateOrUpdateRequestHandler $userPresenceCreateOrUpdateRequestHandler
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->userCreateFullRequestHandler = $userCreateFullRequestHandler;
        $this->userPresenceCreateOrUpdateRequestHandler = $userPresenceCreateOrUpdateRequestHandler;
    }

    public function onChannelEvent(ChannelEvent $event)
    {
        $channel = $event->getChannel();
        // todo: check last update time

        try {
            // todo: fix, its not working, idk why
            $slackConversationMembers = $this->client->conversationsMembers(['channel' => $channel->getChannelId()]);

            foreach ($slackConversationMembers->getMembers() as $userId) {
                $slackUser = $this->client->usersInfo(['user' => $userId])->getUser();
                $userCreateRequest = UserCreateRequest::createFromObjsUser($slackUser);
                $userCreateRequest->setChannelId($channel->getChannelId());
                $this->userCreateFullRequestHandler->handle($userCreateRequest);
            }
            // todo: implement next page cursor
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        // todo: IS IT NOT POSSIBLE? to set team in channel

        // Get presence of channel users
        foreach ($channel->getUsers() as $user) {
            // todo: check time of last update
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
            ChannelEvent::class => 'onChannelEvent',
        ];
    }

}
