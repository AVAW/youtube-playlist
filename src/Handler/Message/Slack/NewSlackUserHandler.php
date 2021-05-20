<?php

declare(strict_types=1);

namespace App\Handler\Message\Slack;

use App\Entity\Slack\SlackUser;
use App\Entity\User\User;
use App\Handler\Request\Slack\User\UserUpdateRequestHandler;
use App\Handler\Request\Slack\UserPresence\UserPresenceCreateOrUpdateRequestHandler;
use App\Handler\Request\User\UserCreateOrUpdateRequestHandler;
use App\Message\Slack\NewSlackUser;
use App\Model\Slack\User\UserUpdateRequest;
use App\Model\Slack\UserPresence\UserPresenceCreateOrUpdateRequest;
use App\Model\User\UserCreateOrUpdateRequest;
use App\Service\Slack\User\SlackUserProvider;
use App\Service\User\UserProvider;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
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
    private UserProvider $userProvider;
    private UserCreateOrUpdateRequestHandler $userCreateOrUpdateRequestHandler;

    public function __construct(
        Client $client,
        LoggerInterface $logger,
        UserPresenceCreateOrUpdateRequestHandler $userPresenceCreateOrUpdateRequestHandler,
        UserUpdateRequestHandler $userUpdateRequestHandler,
        SlackUserProvider $slackUserProvider,
        UserProvider $userProvider,
        UserCreateOrUpdateRequestHandler $userCreateOrUpdateRequestHandler
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->userPresenceCreateOrUpdateRequestHandler = $userPresenceCreateOrUpdateRequestHandler;
        $this->userUpdateRequestHandler = $userUpdateRequestHandler;
        $this->slackUserProvider = $slackUserProvider;
        $this->userProvider = $userProvider;
        $this->userCreateOrUpdateRequestHandler = $userCreateOrUpdateRequestHandler;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
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

        if (empty($slackUser->getEmail())) {
            // Bot user
            return;
        }

        if ($slackUser->getUser() instanceof User) {
            return;
        }

        // Bind SlackUser with User

        // Find existing user account with the same email
        $user = $this->userProvider->findByEmail($slackUser->getEmail());
        if ($user instanceof User) {
            $slackUser->setUser($user);
            $this->slackUserProvider->save($slackUser);
            return;
        }

        $userCreteRequest = UserCreateOrUpdateRequest::create(
            $slackUser->getEmail(),
            $slackUser->getName(),
            null,
            $slackUser
        );
        $this->userCreateOrUpdateRequestHandler->handle($userCreteRequest);
    }

}
