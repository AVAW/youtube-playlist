<?php

declare(strict_types=1);

namespace App\Handler\Request\Command;

use App\Entity\Slack\Command;
use App\Handler\Request\Slack\ConversationPlaylistVideo\ConversationPlaylistVideoFindVideoRequestHandler;
use App\Model\Slack\ConversationPlaylistVideo\ConversationPlaylistVideoFindVideoRequest;
use Twig\Environment;

class CommandSongHandler implements CommandInterface
{

    private ConversationPlaylistVideoFindVideoRequestHandler $conversationPlaylistVideoFindVideoRequestHandler;

    public function __construct(
        ConversationPlaylistVideoFindVideoRequestHandler $conversationPlaylistVideoFindVideoRequestHandler
    ) {
        $this->conversationPlaylistVideoFindVideoRequestHandler = $conversationPlaylistVideoFindVideoRequestHandler;
    }

    public function supports(Command $command): bool
    {
        return $command->getName() === Command::NAME_SONG;
    }

    public function handle(Command $command): string
    {
        $findPlayedVideo = ConversationPlaylistVideoFindVideoRequest::create($command->getConversation());
        $conversationPlaylistVideo = $this->conversationPlaylistVideoFindVideoRequestHandler->handle($findPlayedVideo);

        return $conversationPlaylistVideo->getCurrentVideo()->getTitle();
    }

}
