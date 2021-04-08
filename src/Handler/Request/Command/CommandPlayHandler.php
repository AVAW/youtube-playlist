<?php

declare(strict_types=1);

namespace App\Handler\Request\Command;

use App\Entity\Slack\Command;

class CommandPlayHandler implements CommandInterface
{

    public function supports(Command $command): bool
    {
        return $command->getName() === Command::NAME_PLAY;
    }

    public function handle(Command $command)
    {
        $command->getText(); // playlist url validation
        // create form ?

        // create new room
        // return url
    }

}
