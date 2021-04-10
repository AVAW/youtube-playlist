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
use App\Model\Playlist\PlaylistCreateRequest;
use App\Model\Playlist\Video\VideosCreateRequest;
use App\Model\Slack\ConversationPlaylist\ConversationPlaylistCreateRequest;
use App\Service\Playlist\PlaylistProvider;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use JoliCode\Slack\Api\Client;
use JoliCode\Slack\Exception\SlackErrorResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
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
            $this->conversationPlaylistCreateRequestHandler->handle($conversationPlaylistRequest);

            // todo: message the queue
            $videos = $this->playlistClient->getPlaylistVideos($playlist->getYoutubeId());
            $createVideosRequest = VideosCreateRequest::create($videos);
            $this->videosCreateRequestHandler->handle($playlist, $createVideosRequest);

            $message = $this->twig->render('command/play.html.twig', [
                'playlist' => $playlist,
                'playlistUrl' => $this->router->generate('playlist', ['identifier' => $playlist->getIdentifier()], UrlGeneratorInterface::ABSOLUTE_URL),
            ]);

            try {
                $this->client->chatPostMessage([
                    'username' => 'YouTube playlist BOT',
                    'channel' => '#' . $command->getConversation()->getName(),
                    'text' => $message,
                ]);
            } catch (SlackErrorResponse $e) {
                $this->logger->error($e->getMessage());
            }

            return '';
        }

        return $this->twig->render('command/play_error.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
