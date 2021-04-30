<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\SlashCommands;

use App\Entity\Slack\SlackCommand;
use Twig\Environment;

class CommandBlameHandler implements CommandInterface
{

    private Environment $twig;

    public function __construct(
        Environment $twig
    ) {
        $this->twig = $twig;
    }

    public function supports(SlackCommand $command): bool
    {
        return $command->getName() === SlackCommand::NAME_BLAME;
    }

    public function handle(SlackCommand $command): string
    {
        return 'Use command /song';
        return $this->twig->render('command/blame.html.twig', [
            'conversationPlaylistVideo' => null,
        ]);
    }

}
