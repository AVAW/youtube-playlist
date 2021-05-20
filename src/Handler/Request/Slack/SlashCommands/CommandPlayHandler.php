<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\SlashCommands;

use App\Entity\Playlist\Playlist;
use App\Entity\Slack\SlackCommand;
use App\Form\YouTubePlaylistType;
use App\Handler\Request\Playlist\PlaylistCreateRequestHandler;
use App\Handler\Request\Slack\ConversationPlaylist\ConversationPlaylistCreateRequestHandler;
use App\Handler\Request\Slack\ConversationPlaylist\ConversationPlaylistFindLastPlaylistRequestHandler;
use App\Message\Playlist\PullPlaylistVideos;
use App\Model\Playlist\PlaylistCreateRequest;
use App\Model\Slack\ConversationPlaylist\ConversationPlaylistCreateRequest;
use App\Model\Slack\ConversationPlaylist\ConversationPlaylistFindLastPlaylistRequest;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use JoliCode\Slack\Api\Client;
use JoliCode\Slack\Exception\SlackErrorResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class CommandPlayHandler implements CommandInterface
{

    private Client $client;
    private ConversationPlaylistCreateRequestHandler $conversationPlaylistCreateRequestHandler;
    private Environment $twig;
    private FormFactoryInterface $formFactory;
    private LoggerInterface $logger;
    private MessageBusInterface $bus;
    private PlaylistCreateRequestHandler $playlistCreateRequestHandler;
    private RouterInterface $router;
    private TranslatorInterface $translator;
    private ConversationPlaylistFindLastPlaylistRequestHandler $conversationPlaylistFindLastPlaylistRequestHandler;

    public function __construct(
        Client $client,
        ConversationPlaylistCreateRequestHandler $conversationPlaylistCreateRequestHandler,
        Environment $twig,
        FormFactoryInterface $formFactory,
        LoggerInterface $logger,
        MessageBusInterface $bus,
        PlaylistCreateRequestHandler $playlistCreateRequestHandler,
        RouterInterface $router,
        TranslatorInterface $translator,
        ConversationPlaylistFindLastPlaylistRequestHandler $conversationPlaylistFindLastPlaylistRequestHandler
    ) {
        $this->client = $client;
        $this->conversationPlaylistCreateRequestHandler = $conversationPlaylistCreateRequestHandler;
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->logger = $logger;
        $this->bus = $bus;
        $this->playlistCreateRequestHandler = $playlistCreateRequestHandler;
        $this->router = $router;
        $this->translator = $translator;
        $this->conversationPlaylistFindLastPlaylistRequestHandler = $conversationPlaylistFindLastPlaylistRequestHandler;
    }

    public function supports(SlackCommand $command): bool
    {
        return $command->getName() === SlackCommand::NAME_PLAY;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function handle(SlackCommand $command): ?string
    {
        if (empty($command->getText())) {
            // Return current playlist
            $findConversationPlaylist = ConversationPlaylistFindLastPlaylistRequest::create($command->getConversation());
            $playlist = $this->conversationPlaylistFindLastPlaylistRequestHandler->handle($findConversationPlaylist);
            if ($playlist instanceof Playlist) {
                $this->sendSlackChatMessage($command, $playlist);
                return null;
            }

            return $this->translator->trans('playlist.error.nothingIsPlayed');
        }

        $createPlaylistCommand = new PlaylistCreateRequest();
        $form = $this->formFactory->create(YouTubePlaylistType::class, $createPlaylistCommand);
        $form->submit([
            'url' => $command->getText(),
        ]);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Playlist $playlist */
            $createPlaylistCommand = $form->getData();

            $playlist = $this->playlistCreateRequestHandler->handle($createPlaylistCommand, $command);

            // Bind conversation and playlist
            $conversationPlaylistRequest = ConversationPlaylistCreateRequest::create($playlist, $command->getConversation());
            $conversationPlaylist = $this->conversationPlaylistCreateRequestHandler->handle($conversationPlaylistRequest);

            $this->bus->dispatch(new PullPlaylistVideos((string) $playlist->getIdentifier()));

            $this->sendSlackChatMessage($command, $playlist);

            return $this->translator->trans('playlist.success.created');
        }

        return $this->twig->render('command/play_error.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    protected function sendSlackChatMessage(SlackCommand $command, Playlist $playlist)
    {
        try {
            $this->client->chatPostMessage([
                'channel' => '#' . $command->getConversation()->getName(),
                'username' => $this->translator->trans('name'),
                'blocks' => $this->createSlackBlock($command, $playlist),
            ]);
        } catch (SlackErrorResponse $e) {
            $this->logger->error($e->getMessage());
        }
    }

    protected function createSlackBlock(SlackCommand $command, Playlist $playlist): string
    {
        $playlistUrl = $this->router->generate('playlist', ['identifier' => $playlist->getIdentifier()], UrlGeneratorInterface::ABSOLUTE_URL);

        return json_encode([
            [
                'type' => 'header',
                'text' => [
                    'type' => 'plain_text',
                    'text' => $playlist->getTitle(),
                    'emoji' => true,
                ],
            ],
            [
                'type' => 'section',
                'text' => [
                    'type' => 'mrkdwn',
                    'text' => $this->translator->trans('playlist.success.credits', [
                        '%author%' => $command->getUser()->getName(),
                        '%at%' => $playlist->getCreatedAt()->format('H:i:s d.m.Y'),
                    ]),
                ],
                'accessory' => [
                    'type' => 'button',
                    'text' => [
                        'type' => 'plain_text',
                        'text' => ':notes: ' . $this->translator->trans('playlist.open') . ' :notes:',
                        'emoji' => true,
                    ],
                    'value' => $playlist->getIdentifier(),
                    'url' => $playlistUrl,
                    'action_id' => 'click-open-playlist-button',
                ],
            ],
            [
                'type' => 'divider',
            ],
            [
                'type' => 'section',
                'fields' => [
                    [
                        'type' => 'mrkdwn',
                        'text' => "*YouTube playlist creator:*\n{$playlist->getChannelTitle()}",
                    ],
                    [
                        'type' => 'mrkdwn',
                        'text' => "*Songs amount:*\n{$playlist->getVideosAmount()}",
                    ],
                ],
            ],
        ]);
    }

}
