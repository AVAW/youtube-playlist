<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\SlashCommands;

use App\Entity\Slack\SlackCommand;

interface CommandInterface
{

    public function supports(SlackCommand $command): bool;

    public function handle(SlackCommand $command): ?string;

}
