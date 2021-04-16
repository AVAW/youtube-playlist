<?php

declare(strict_types=1);

namespace App\Handler\Request\Command;

use App\Entity\Playlist\PlaylistVideo;
use App\Entity\Slack\Command;
use App\Entity\Slack\ConversationPlaylistVideo;
use App\Handler\Request\Slack\ConversationPlaylistVideo\ConversationPlaylistVideoFindVideoRequestHandler;
use App\Model\Slack\ConversationPlaylistVideo\ConversationPlaylistVideoFindVideoRequest;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class CommandSongHandler implements CommandInterface
{

    private ConversationPlaylistVideoFindVideoRequestHandler $conversationPlaylistVideoFindVideoRequestHandler;
    private TranslatorInterface $translator;

    public function __construct(
        ConversationPlaylistVideoFindVideoRequestHandler $conversationPlaylistVideoFindVideoRequestHandler,
        TranslatorInterface $translator
    ) {
        $this->conversationPlaylistVideoFindVideoRequestHandler = $conversationPlaylistVideoFindVideoRequestHandler;
        $this->translator =$translator;
    }

    public function supports(Command $command): bool
    {
        return $command->getName() === Command::NAME_SONG;
    }

    public function handle(Command $command): string
    {
        $findPlayedVideo = ConversationPlaylistVideoFindVideoRequest::create($command->getConversation());
        $conversationPlaylistVideo = $this->conversationPlaylistVideoFindVideoRequestHandler->handle($findPlayedVideo);
        if ($conversationPlaylistVideo instanceof ConversationPlaylistVideo) {
            $currentVideo = $conversationPlaylistVideo->getCurrentVideo();
            if ($currentVideo instanceof PlaylistVideo) {
                return $currentVideo->getTitle();
            }
        }

        return $this->translator->trans('playlist.error.nothingIsPlayed');
    }

}
