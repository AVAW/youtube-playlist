<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\SlashCommands;

use App\Entity\Playlist\Playlist;
use App\Entity\Playlist\PlaylistPlay;
use App\Entity\Playlist\PlaylistVideo;
use App\Entity\Slack\SlackAction;
use App\Entity\Slack\SlackCommand;
use App\Handler\Request\Slack\ConversationPlaylist\ConversationPlaylistFindLastPlaylistRequestHandler;
use App\Model\Slack\ConversationPlaylist\ConversationPlaylistFindLastPlaylistRequest;
use App\Service\Playlist\PlaylistProvider;
use JoliCode\Slack\Api\Client;
use JoliCode\Slack\Exception\SlackErrorResponse;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class CommandSongHandler implements CommandInterface
{

    private Client $client;
    private LoggerInterface $logger;
    private ConversationPlaylistFindLastPlaylistRequestHandler $conversationPlaylistFindLastPlaylistRequestHandler;
    private TranslatorInterface $translator;
    private PlaylistProvider $playlistProvider;

    public function __construct(
        Client $client,
        LoggerInterface $logger,
        ConversationPlaylistFindLastPlaylistRequestHandler $conversationPlaylistFindLastPlaylistRequestHandler,
        TranslatorInterface $translator,
        PlaylistProvider $playlistProvider
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->conversationPlaylistFindLastPlaylistRequestHandler = $conversationPlaylistFindLastPlaylistRequestHandler;
        $this->translator = $translator;
        $this->playlistProvider = $playlistProvider;
    }

    public function supports(SlackCommand $command): bool
    {
        return $command->getName() === SlackCommand::NAME_SONG;
    }

    public function handle(SlackCommand $command): string
    {
        $findConversationPlaylist = ConversationPlaylistFindLastPlaylistRequest::create($command->getConversation());
        $playlist = $this->conversationPlaylistFindLastPlaylistRequestHandler->handle($findConversationPlaylist);
        if (!$playlist instanceof Playlist) {
            return $this->translator->trans('playlist.error.nothingIsPlayed');
        }

        $playlist = $this->playlistProvider->findOneByIdentifierWithVideosAndPlay((string) $playlist->getIdentifier());
        if (!$playlist->getPlay() instanceof PlaylistPlay) {
            return $this->translator->trans('playlist.error.nothingIsPlayed2');
        }

        $this->sendSlackChatMessage($command, $playlist);

        return '';
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
        $video = $playlist->getPlay()->getVideo();
        $videoUrl = 'https://www.youtube.com/watch?v=' . $video->getVideoId();

        return json_encode([
            [
                'type' => 'header',
                'text' => [
                    'type' => 'plain_text',
                    'text' => $video->getTitle(),
                    'emoji' => true,
                ],
            ],
            [
                'type' => 'section',
                'text' => [
                    'type' => 'mrkdwn',
                    'text' => "*Song in youtube:*\n<$videoUrl|$videoUrl>",
                ],
            ],
            [
                'type' => 'section',
                'text' => [
                    'type' => 'mrkdwn',
                    'text' => "*Added by:*\n{$this->getAuthorsAsString($video)}",
                ],
            ],
            [
                'type' => 'section',
                'fields' => [
                    [
                        'type' => 'mrkdwn',
                        'text' => "*Channel title:*\n{$this->getChannelTitle($video)}",
                    ],
                    [
                        'type' => 'mrkdwn',
                        'text' => "*Added At:*\n{$video->getPublishedAt()->format('d.m.Y H:i:s')}",
                    ],
                ],
            ],
            [
                'type' => 'actions',
                'elements' => [
                    [
                        'type' => 'button',
                        'text' => [
                            'type' => 'plain_text',
                            'emoji' => true,
                            'text' => $this->translator->trans('playlist.song.skip') . ' :black_right_pointing_double_triangle_with_vertical_bar:',
                        ],
                        'value' => $video->getIdentifier(),
                        'action_id' => SlackAction::ACTION_ID_CLICK_PLAYLIST_VIDEO_SKIP,
                    ],
                    [
                        'type' => 'button',
                        'text' => [
                            'type' => 'plain_text',
                            'emoji' => true,
                            'text' => $this->translator->trans('playlist.song.remove') . ' :put_litter_in_its_place:',
                        ],
                        'value' => $video->getIdentifier(),
                        'action_id' => SlackAction::ACTION_ID_CLICK_PLAYLIST_VIDEO_REMOVE,
                    ],
                ],
            ],
            [
                'type' => 'divider',
            ],
        ]);
    }

    protected function getAuthorsAsString(PlaylistVideo $video): string
    {
        $authorsArray = [];
        foreach ($video->getAuthors() as $author) {
            $authorsArray [] = '@' . $author->getLogin();
        }

        if (empty($authorsArray)) {
            return '-';
        }

        return implode(', ', $authorsArray);
    }

    protected function getChannelTitle(PlaylistVideo $video): string
    {
        if (empty($video->getVideoOwnerChannelTitle())) {
            return '-';
        }

        return $video->getVideoOwnerChannelTitle();
    }

}
