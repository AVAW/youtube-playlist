<?php

declare(strict_types=1);

namespace App\EventSubscriber\Command\Slack;

use App\Event\Slack\NewUserEvent;
use App\Handler\Request\Slack\User\UserUpdateRequestHandler;
use App\Handler\Request\Slack\UserPresence\UserPresenceCreateOrUpdateRequestHandler;
use App\Model\Slack\User\UserUpdateRequest;
use App\Model\Slack\UserPresence\UserPresenceCreateOrUpdateRequest;
use JoliCode\Slack\Api\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NewUserSubscriber implements EventSubscriberInterface
{

    private Client $client;
    private LoggerInterface $logger;
    private UserPresenceCreateOrUpdateRequestHandler $userPresenceCreateOrUpdateRequestHandler;
    private UserUpdateRequestHandler $userUpdateRequestHandler;

    public function __construct(
        Client $client,
        LoggerInterface $logger,
        UserPresenceCreateOrUpdateRequestHandler $userPresenceCreateOrUpdateRequestHandler,
        UserUpdateRequestHandler $userUpdateRequestHandler
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->userPresenceCreateOrUpdateRequestHandler = $userPresenceCreateOrUpdateRequestHandler;
        $this->userUpdateRequestHandler = $userUpdateRequestHandler;
    }

    public function onNewUserEvent(NewUserEvent $event)
    {
        $user = $event->getUser();

        // Get user data
        try {
            $slackUser = $this->client->usersInfo(['user' => $user->getUserId()])->getUser();
            $updateUserRequest = UserUpdateRequest::createFromObjsUser($slackUser);
            $this->userUpdateRequestHandler->handle($user, $updateUserRequest);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }

        // Get user presence
        try {
            $slackPresence = $this->client->usersGetPresence(['user' => $user->getUserId()]);
            $command = UserPresenceCreateOrUpdateRequest::createFromUserPresence($slackPresence);
            $this->userPresenceCreateOrUpdateRequestHandler->handle($user, $command);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NewUserEvent::class => 'onNewUserEvent',
        ];
    }

}
