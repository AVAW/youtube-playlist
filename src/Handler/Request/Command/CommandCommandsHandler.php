<?php

declare(strict_types=1);

namespace App\Handler\Request\Command;

use App\Entity\Slack\Command;
use Twig\Environment;

class CommandCommandsHandler implements CommandInterface
{

    private Environment $twig;

    public function __construct(
        Environment $twig
    ) {
        $this->twig = $twig;
    }

    public function supports(Command $command): bool
    {
        return $command->getName() === Command::NAME_COMMANDS;
    }

    public function handle(Command $command): string
    {
        return $this->twig->render('slack_command/commands.html.twig');
    }

}
