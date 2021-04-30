<?php

declare(strict_types=1);

namespace App\Handler\Message\Slack;

use App\Entity\Slack\SlackUser;
use App\Handler\Request\Slack\User\UserUpdateRequestHandler;
use App\Handler\Request\Slack\UserPresence\UserPresenceCreateOrUpdateRequestHandler;
use App\Message\Slack\NewSlackUser;
use App\Model\Slack\User\UserUpdateRequest;
use App\Model\Slack\UserPresence\UserPresenceCreateOrUpdateRequest;
use App\Service\Slack\User\SlackUserProvider;
use JoliCode\Slack\Api\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class NewSlackUserHandler implements MessageHandlerInterface
{

    private Client $client;
    private LoggerInterface $logger;
    private UserPresenceCreateOrUpdateRequestHandler $userPresenceCreateOrUpdateRequestHandler;
    private UserUpdateRequestHandler $userUpdateRequestHandler;
    private SlackUserProvider $slackUserProvider;

    public function __construct(
        Client $client,
        LoggerInterface $logger,
        UserPresenceCreateOrUpdateRequestHandler $userPresenceCreateOrUpdateRequestHandler,
        UserUpdateRequestHandler $userUpdateRequestHandler,
        SlackUserProvider $slackUserProvider
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->userPresenceCreateOrUpdateRequestHandler = $userPresenceCreateOrUpdateRequestHandler;
        $this->userUpdateRequestHandler = $userUpdateRequestHandler;
        $this->slackUserProvider = $slackUserProvider;
    }

    public function __invoke(NewSlackUser $newSlackUser)
    {
        $slackUser = $this->slackUserProvider->findByIdentifier($newSlackUser->getIdentifier());
        if (!$slackUser instanceof SlackUser) {
            return;
        }

        // Get slack user data
        try {
            $slackUserInfo = $this->client->usersInfo(['user' => $slackUser->getProfileId()])->getUser();
            $updateUserRequest = UserUpdateRequest::createFromObjsUser($slackUserInfo);
            $this->userUpdateRequestHandler->handle($slackUser, $updateUserRequest);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }

        // Get slack user presence
        try {
            $slackPresence = $this->client->usersGetPresence(['user' => $slackUser->getProfileId()]);
            $command = UserPresenceCreateOrUpdateRequest::createFromUserPresence($slackPresence);
            $this->userPresenceCreateOrUpdateRequestHandler->handle($slackUser, $command);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }

        // zakładanie konta użytkownika
        // user może mieć już konto przed integracją - poszukaj po mailu
        // jeśli ma to powiąż user z slackuser
        // jesli nie to stwórz nowe z użytkownikiem ze slacka? czy damy możliwość edycji loginu?
        // todo:

        // $user = userProvider->findByMail();
        // $slackProfile = $slackUserProvider->findByMail();
        //

        // Create user
        $command = UserCreateOrUpdate::createFrom($slackUser);
        $this->userCreateOrUpdateHandler->handle($command);
    }

}
