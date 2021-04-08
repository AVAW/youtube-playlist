<?php

declare(strict_types=1);

namespace App\Service\Slack\Command;

use App\Entity\Slack\Conversation;
use App\Entity\Slack\Command;
use App\Entity\Slack\Team;
use App\Entity\Slack\User;
use Symfony\Component\Uid\Uuid;

class CommandManager
{

    protected CommandProvider $provider;

    public function __construct(CommandProvider $commandProvider)
    {
        $this->provider = $commandProvider;
    }

    public function create(
        Team $team,
        Conversation $conversation,
        User $user,
        string $name,
        ?string $text
    ): Command {
        $command = (new Command())
            ->setName($name)
            ->setTeam($team)
            ->setConversation($conversation)
            ->setUser($user)
            ->setText($text)
            ->setIdentifier(Uuid::v4());

        $this->provider->save($command);

        return $command;
    }

}
