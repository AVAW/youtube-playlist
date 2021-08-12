<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\User;

use App\Entity\Slack\SlackConversation;
use App\Entity\Slack\SlackUser;
use App\Message\Slack\NewSlackUser;
use App\Service\Slack\User\SlackUserManager;
use App\Service\Slack\User\SlackUserProvider;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class UserCollectionGetOrCreateRequestHandler
{

    private EventDispatcherInterface $dispatcher;
    private SlackUserManager $userManager;
    private SlackUserProvider $userProvider;
    private MessageBusInterface $bus;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        SlackUserManager $userManager,
        SlackUserProvider $userProvider,
        MessageBusInterface $bus
    ) {
        $this->dispatcher = $dispatcher;
        $this->userManager = $userManager;
        $this->userProvider = $userProvider;
        $this->bus = $bus;
    }

    /**
     * @return SlackUser[]
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle(UserCollectionGetOrCreateInterface $command, SlackConversation $conversation): void
    {
        foreach ($command->getUsersIds() as $usersId) {
            $user = $this->userProvider->findBySlackUserId($usersId);
            if ($user instanceof SlackUser) {
                continue;
            }

            $user = $this->userManager->create(
                $usersId,
                null,
                null,
                $conversation
            );

            $this->bus->dispatch(new NewSlackUser((string) $user->getIdentifier()));
        }
    }

}
