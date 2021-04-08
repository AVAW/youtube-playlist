<?php

declare(strict_types=1);

namespace App\Handler\Request\Command;

use App\Entity\Slack\Command;

interface CommandInterface
{

    public function supports(Command $command): bool;

    public function handle(Command $command);

}
