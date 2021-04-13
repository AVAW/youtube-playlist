<?php

declare(strict_types=1);

namespace App\Handler\Request\Command;

use App\Entity\Playlist\Playlist;
use App\Entity\Slack\Command;
use App\Form\YouTubePlaylistType;
use App\Handler\Request\Playlist\PlaylistCreateRequestHandler;
use App\Handler\Request\Playlist\Video\VideosCreateRequestHandler;
use App\Handler\Request\Slack\ConversationPlaylist\ConversationPlaylistCreateRequestHandler;
use App\Http\YouTube\PlaylistClient;
use App\Message\Playlist\PullPlaylistVideos;
use App\Model\Playlist\PlaylistCreateRequest;
use App\Model\Slack\ConversationPlaylist\ConversationPlaylistCreateRequest;
use App\Service\Playlist\PlaylistProvider;
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
    private PlaylistClient $playlistClient;
    private PlaylistCreateRequestHandler $playlistCreateRequestHandler;
    private PlaylistProvider $playlistProvider;
    private RouterInterface $router;
    private TranslatorInterface $translator;
    private VideosCreateRequestHandler $videosCreateRequestHandler;

    public function __construct(
        Client $client,
        ConversationPlaylistCreateRequestHandler $conversationPlaylistCreateRequestHandler,
        Environment $twig,
        FormFactoryInterface $formFactory,
        LoggerInterface $logger,
        MessageBusInterface $bus,
        PlaylistClient $playlistClient,
        PlaylistCreateRequestHandler $playlistCreateRequestHandler,
        PlaylistProvider $playlistProvider,
        RouterInterface $router,
        TranslatorInterface $translator,
        VideosCreateRequestHandler $videosCreateRequestHandler
    ) {
        $this->client = $client;
        $this->conversationPlaylistCreateRequestHandler = $conversationPlaylistCreateRequestHandler;
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->logger = $logger;
        $this->bus = $bus;
        $this->playlistClient = $playlistClient;
        $this->playlistCreateRequestHandler = $playlistCreateRequestHandler;
        $this->playlistProvider = $playlistProvider;
        $this->router = $router;
        $this->translator = $translator;
        $this->videosCreateRequestHandler = $videosCreateRequestHandler;
    }

    public function supports(Command $command): bool
    {
        return $command->getName() === Command::NAME_PLAY;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function handle(Command $command): string
    {
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

            $playlistUrl = $this->router->generate('playlist', ['identifier' => $playlist->getIdentifier()], UrlGeneratorInterface::ABSOLUTE_URL);
            $message = $this->twig->render('command/play.html.twig', [
                'playlist' => $playlist,
                'playlistUrl' => $playlistUrl,
                'creator' => $command->getUser(),
                'votesToSkip' => $conversationPlaylist->getConversation()->getUsers()->count(),
            ]);

            try {
                $this->client->chatPostMessage([
                    'channel' => '#' . $command->getConversation()->getName(),
                    'username' => $this->translator->trans('name'),
                    'blocks' => json_encode([
                        [
                            'type' => 'section',
                            'text' => [
                                'type' => 'mrkdwn',
                                'text' => "Playlist address (URL):\n*<$playlistUrl|$playlistUrl>*",
                            ],
                            'accessory' => [
                                'type' => 'button',
                                'text' => [
                                    'type' => 'plain_text',
                                    'text' => 'Open playlist',
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
                                    'text' => "*YouTube playlist title:*\n{$playlist->getTitle()}",
                                ],
                                [
                                    'type' => 'mrkdwn',
                                    'text' => "*YouTube playlist description:*\n{$playlist->getDescription()}",
                                ],
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
                        [
                            'type' => 'divider',
                        ],
                        [
                            'type' => 'section',
                            'text' => [
                                'type' => 'mrkdwn',
                                'text' => 'Playlist created by *@' . $command->getUser()->getDisplayedName() . '* at ' . $playlist->getCreatedAt()->format('d.m.Y H:i:s'),
                            ],
                        ],
                        [
                            'type' => 'divider',
                        ],
                    ]),
                ]);
            } catch (SlackErrorResponse $e) {
                $this->logger->error($e->getMessage());
            }

            return $this->translator->trans('playlist.success.created');
        }

        return $this->twig->render('command/play_error.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
