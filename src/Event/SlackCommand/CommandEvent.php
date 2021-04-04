<?php

declare(strict_types=1);

namespace App\Event\SlackCommand;

use App\Entity\Slack\Command;
use Symfony\Contracts\EventDispatcher\Event;

class CommandEvent extends Event
{

    private Command $command;

    public function __construct(
        Command $command
    ) {
        $this->command = $command;
    }

    public function getCommand(): Command
    {
        return $this->command;
    }

}
