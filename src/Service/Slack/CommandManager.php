<?php

declare(strict_types=1);

namespace App\Service\Slack;

use App\Entity\Slack\Channel;
use App\Entity\Slack\Command;
use App\Entity\Slack\Team;
use App\Entity\Slack\User;
use App\Repository\Slack\CommandRepository;

class CommandManager
{

    protected CommandRepository $commandRepository;

    public function __construct(
        CommandRepository $commandRepository
    ) {
        $this->commandRepository = $commandRepository;
    }

    public function create(
        Team $team,
        Channel $channel,
        User $user,
        string $name,
        ?string $text
    ): Command {
        $command = (new Command())
            ->setName($name)
            ->setTeam($team)
            ->setChannel($channel)
            ->setUser($user)
            ->setText($text);

        $this->commandRepository->save($command);

        return $command;
    }

}
