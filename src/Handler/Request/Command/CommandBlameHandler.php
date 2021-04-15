<?php

declare(strict_types=1);

namespace App\Handler\Request\Command;

use App\Entity\Slack\Command;
use App\Handler\Request\Slack\ConversationPlaylistVideo\ConversationPlaylistVideoFindVideoRequestHandler;
use App\Model\Slack\ConversationPlaylistVideo\ConversationPlaylistVideoFindVideoRequest;
use Twig\Environment;

class CommandBlameHandler implements CommandInterface
{

    private Environment $twig;
    private ConversationPlaylistVideoFindVideoRequestHandler $conversationPlaylistVideoFindVideoRequestHandler;

    public function __construct(
        ConversationPlaylistVideoFindVideoRequestHandler $conversationPlaylistVideoFindVideoRequestHandler,
        Environment $twig
    ) {
        $this->conversationPlaylistVideoFindVideoRequestHandler = $conversationPlaylistVideoFindVideoRequestHandler;
        $this->twig = $twig;
    }

    public function supports(Command $command): bool
    {
        return $command->getName() === Command::NAME_BLAME;
    }

    public function handle(Command $command): string
    {
        $findPlayedVideo = ConversationPlaylistVideoFindVideoRequest::create($command->getConversation());
        $conversationPlaylistVideo = $this->conversationPlaylistVideoFindVideoRequestHandler->handle($findPlayedVideo);

        return $this->twig->render('command/blame.html.twig', [
            'conversationPlaylistVideo' => $conversationPlaylistVideo,
        ]);
    }

}
