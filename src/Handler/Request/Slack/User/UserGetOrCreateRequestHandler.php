<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\User;

use App\Entity\Slack\SlackUser;
use App\Message\Slack\NewSlackUser;
use App\Service\Slack\User\SlackUserManager;
use App\Service\Slack\User\SlackUserProvider;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class UserGetOrCreateRequestHandler
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
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle(UserGetOrCreateInterface $command): SlackUser
    {
        $user = $this->userProvider->findBySlackUserId($command->getUserId());
        if (!$user instanceof SlackUser) {
            $user = $this->userManager->create(
                $command->getUserId(),
                $command->getUserName(),
            );

            $this->bus->dispatch(new NewSlackUser((string) $user->getIdentifier()));
        }

        return $user;
    }

}
