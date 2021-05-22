<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Command;

use App\Entity\Slack\SlackConversation;
use App\Entity\Slack\SlackCommand;
use App\Entity\Slack\SlackTeam;
use App\Entity\Slack\SlackUser;
use App\Service\Slack\Command\SlackCommandManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class CommandCreateRequestHandler
{

    private SlackCommandManager $commandManager;

    public function __construct(
        SlackCommandManager $commandManager
    ) {
        $this->commandManager = $commandManager;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle(SlackTeam $team, SlackConversation $conversation, SlackUser $user, CommandCreateInterface $command): SlackCommand
    {
        return $this->commandManager->create(
            $team,
            $conversation,
            $user,
            $command->getCommand(),
            $command->getText()
        );
    }

}
