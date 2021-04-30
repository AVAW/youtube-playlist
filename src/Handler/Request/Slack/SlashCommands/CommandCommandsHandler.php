<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\SlashCommands;

use App\Entity\Slack\SlackCommand;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class CommandCommandsHandler implements CommandInterface
{

    private Environment $twig;

    public function __construct(
        Environment $twig
    ) {
        $this->twig = $twig;
    }

    public function supports(SlackCommand $command): bool
    {
        return $command->getName() === SlackCommand::NAME_COMMANDS;
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function handle(SlackCommand $command): string
    {
        return $this->twig->render('command/commands.html.twig');
    }

}
