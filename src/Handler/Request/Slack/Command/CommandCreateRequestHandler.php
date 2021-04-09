<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Command;

use App\Entity\Slack\Conversation;
use App\Entity\Slack\Command;
use App\Entity\Slack\Team;
use App\Entity\Slack\User;
use App\Event\Slack\NewCommandEvent;
use App\Service\Slack\Command\CommandManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class CommandCreateRequestHandler
{

    private EventDispatcherInterface $dispatcher;
    private CommandManager $commandManager;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        CommandManager $commandManager
    ) {
        $this->dispatcher = $dispatcher;
        $this->commandManager = $commandManager;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle(Team $team, Conversation $conversation, User $user, CommandCreateInterface $command): Command
    {
        $command = $this->commandManager->create(
            $team,
            $conversation,
            $user,
            $command->getCommand(),
            $command->getText()
        );

        $this->dispatcher->dispatch(new NewCommandEvent($command));

        return $command;
    }

}
