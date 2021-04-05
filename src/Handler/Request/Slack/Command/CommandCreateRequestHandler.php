<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Command;

use App\Entity\Slack\Channel;
use App\Entity\Slack\Command;
use App\Entity\Slack\Team;
use App\Entity\Slack\User;
use App\Service\Slack\Command\CommandManager;

class CommandCreateRequestHandler
{

    private CommandManager $commandManager;

    public function __construct(
        CommandManager $commandManager
    ) {
        $this->commandManager = $commandManager;
    }

    public function handle(Team $team, Channel $channel, User $user, CommandCreateInterface $command): Command
    {
        return $this->commandManager->create(
            $team,
            $channel,
            $user,
            $command->getCommand(),
            $command->getText()
        );
    }

}
