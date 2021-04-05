<?php

declare(strict_types=1);

namespace App\Service\Slack\Command;

use App\Entity\Slack\Channel;
use App\Entity\Slack\Command;
use App\Entity\Slack\Team;
use App\Entity\Slack\User;

class CommandManager
{

    protected CommandProvider $provider;

    public function __construct(CommandProvider $commandProvider)
    {
        $this->provider = $commandProvider;
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

        $this->provider->save($command);

        return $command;
    }

}
