<?php

declare(strict_types=1);

namespace App\Handler\Request\Command;

use App\Entity\Slack\Command;
use App\Handler\Request\Slack\ConversationPlaylist\ConversationPlaylistFindLastPlaylistRequestHandler;
use App\Model\Slack\ConversationPlaylist\ConversationPlaylistFindLastPlaylistRequest;
use Doctrine\ORM\NonUniqueResultException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class CommandAmountHandler implements CommandInterface
{

    private ConversationPlaylistFindLastPlaylistRequestHandler $conversationPlaylistFindLastPlaylistRequestHandler;
    private Environment $twig;

    public function __construct(
        ConversationPlaylistFindLastPlaylistRequestHandler $conversationPlaylistFindLastPlaylistRequestHandler,
        Environment $twig
    ) {
        $this->conversationPlaylistFindLastPlaylistRequestHandler = $conversationPlaylistFindLastPlaylistRequestHandler;
        $this->twig = $twig;
    }

    public function supports(Command $command): bool
    {
        return $command->getName() === Command::NAME_AMOUNT;
    }

    /**
     * @throws NonUniqueResultException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function handle(Command $command): string
    {
        $findConversationPlaylist = ConversationPlaylistFindLastPlaylistRequest::create($command->getConversation());
        $playlist = $this->conversationPlaylistFindLastPlaylistRequestHandler->handle($findConversationPlaylist);

        return $this->twig->render('command/amount.html.twig', [
            'playlist' => $playlist,
        ]);
    }

}
