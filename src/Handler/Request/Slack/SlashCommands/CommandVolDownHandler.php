<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\SlashCommands;

use App\Entity\Slack\SlackCommand;
use Twig\Environment;

class CommandVolDownHandler implements CommandInterface
{

    private Environment $twig;

    public function __construct(
        Environment $twig
    ) {
        $this->twig = $twig;
    }

    public function supports(SlackCommand $command): bool
    {
        return $command->getName() === SlackCommand::NAME_VOL_DOWN;
    }

    public function handle(SlackCommand $command): string
    {
    }

}
