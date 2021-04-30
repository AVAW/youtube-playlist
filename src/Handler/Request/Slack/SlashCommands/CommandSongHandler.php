<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\SlashCommands;

use App\Entity\Playlist\PlaylistVideo;
use App\Entity\Slack\SlackCommand;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class CommandSongHandler implements CommandInterface
{

    private TranslatorInterface $translator;

    public function __construct(
        TranslatorInterface $translator
    ) {
        $this->translator =$translator;
    }

    public function supports(SlackCommand $command): bool
    {
        return $command->getName() === SlackCommand::NAME_SONG;
    }

    public function handle(SlackCommand $command): string
    {
        return $this->translator->trans('playlist.error.nothingIsPlayed');
    }

}
