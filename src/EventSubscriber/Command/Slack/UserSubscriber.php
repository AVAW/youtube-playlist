<?php

declare(strict_types=1);

namespace App\EventSubscriber\Command\Slack;

use App\Event\Slack\UserEvent;
use App\Handler\Request\Slack\User\UserUpdateRequestHandler;
use App\Model\Slack\User\UserUpdateRequest;
use App\Utils\LastUpdateHelper;
use JoliCode\Slack\Api\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{

    private Client $client;
    private LoggerInterface $logger;
    private UserUpdateRequestHandler $userUpdateRequestHandler;

    public function __construct(
        Client $client,
        LoggerInterface $logger,
        UserUpdateRequestHandler $userUpdateRequestHandler
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->userUpdateRequestHandler = $userUpdateRequestHandler;
    }

    public function onUserEvent(UserEvent $event)
    {
        $user = $event->getUser();

        // Get user data
        if (!LastUpdateHelper::isUpdatedInLastXMinutes($user, 10)) {
            try {
                $slackUser = $this->client->usersInfo(['user' => $user->getUserId()])->getUser();
                $updateUserRequest = UserUpdateRequest::createFromObjsUser($slackUser);
                $this->userUpdateRequestHandler->handle($user, $updateUserRequest);
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserEvent::class => 'onUserEvent',
        ];
    }

}
