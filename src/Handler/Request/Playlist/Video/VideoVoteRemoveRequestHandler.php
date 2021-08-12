<?php

declare(strict_types=1);

namespace App\Handler\Request\Playlist\Video;

use App\Entity\Playlist\PlaylistPlay;
use App\Entity\Playlist\PlaylistVideo;
use App\Entity\Slack\SlackConversation;
use App\Entity\Slack\SlackUser;
use App\Entity\Vote\VotePlaylistVideo;
use App\Service\Playlist\Video\PlaylistVideoProvider;
use App\Service\Slack\ConversationPlaylist\SlackConversationPlaylistProvider;
use App\Service\User\UserPresence\UserPresenceManager;
use App\Service\Vote\VotePlaylistVideoCalculator;
use App\Service\Vote\VotePlaylistVideoManager;
use App\Service\Vote\VotePlaylistVideoProvider;
use JoliCode\Slack\Api\Client;
use JoliCode\Slack\Exception\SlackErrorResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class VideoVoteRemoveRequestHandler
{

    private AuthorizationCheckerInterface $authorizationChecker;
    private Client $client;
    private LoggerInterface $logger;
    private PlaylistVideoProvider $playlistVideoProvider;
    private VotePlaylistVideoCalculator $votePlaylistVideoCalculator;
    private VotePlaylistVideoManager $votePlaylistVideoManager;
    private VotePlaylistVideoProvider $votePlaylistVideoProvider;
    private TranslatorInterface $translator;
    private UserPresenceManager $userPresenceManager;
    private SlackConversationPlaylistProvider $slackConversationPlaylistProvider;
    private ChatterInterface $chatter;

    public function __construct(
        AuthorizationCheckerInterface $authorizationChecker,
        Client $client,
        LoggerInterface $logger,
        PlaylistVideoProvider $playlistVideoProvider,
        VotePlaylistVideoCalculator $votePlaylistVideoCalculator,
        VotePlaylistVideoManager $votePlaylistVideoManager,
        VotePlaylistVideoProvider $votePlaylistVideoProvider,
        TranslatorInterface $translator,
        UserPresenceManager $userPresenceManager,
        SlackConversationPlaylistProvider $slackConversationPlaylistProvider,
        ChatterInterface $chatter
    ) {
        $this->authorizationChecker = $authorizationChecker;
        $this->client = $client;
        $this->logger = $logger;
        $this->playlistVideoProvider = $playlistVideoProvider;
        $this->votePlaylistVideoCalculator = $votePlaylistVideoCalculator;
        $this->votePlaylistVideoManager = $votePlaylistVideoManager;
        $this->votePlaylistVideoProvider = $votePlaylistVideoProvider;
        $this->translator = $translator;
        $this->userPresenceManager = $userPresenceManager;
        $this->slackConversationPlaylistProvider = $slackConversationPlaylistProvider;
        $this->chatter = $chatter;
    }

    public function handle(VideoVoteRemoveInterface $command): ?string
    {
        $video = $this->playlistVideoProvider->findByIdentifier($command->getVideoIdentifier());
        if (!$video instanceof PlaylistVideo) {
            throw new \InvalidArgumentException('Video dose not exists: ' . $command->getVideoIdentifier());
        }

        $playlist = $video->getPlaylist();
        $play = $playlist->getPlay();
        if (!$play instanceof PlaylistPlay) {
            return $this->translator->trans('playlist.error.nothingIsPlayed2');
        }

        $currentVideo = $play->getVideo();
        if ($video !== $currentVideo) {
            return $this->translator->trans('vote.playlist.video.tooLate');
        }

        $user = $command->getUser();
        $slackConversationPlaylist = $this->slackConversationPlaylistProvider->findByPlaylist($playlist);
        $conversation = $slackConversationPlaylist->getConversation();

        // Check if user voted for this video
        $vote = $this->votePlaylistVideoProvider->findVote(VotePlaylistVideo::ACTION_REMOVE, $video, $user, $play->getStartedAt(), $command->votedAt());
        if ($vote instanceof VotePlaylistVideo) {
            return $this->translator->trans('vote.playlist.video.alreadyVoted');
        }

        // Create vote
        $vote = $this->votePlaylistVideoManager->create(
            VotePlaylistVideo::ACTION_REMOVE,
            $user,
            $video,
            $command->votedAt(),
        );

        // Count votes
        $votes = $this->votePlaylistVideoProvider->findAllVotes(VotePlaylistVideo::ACTION_REMOVE, $video, $play->getStartedAt(), $command->votedAt());
        // Check users presence
        $users = $this->userPresenceManager->getPresentUsers($playlist);
        // Decide how much votes we need
        $calculator = $this->votePlaylistVideoCalculator->init(count($votes), count($users));

        $this->sendSlackChatMessage($conversation, $user->getSlackUser(), $video, $calculator);

        if ($calculator->isFulfilled()) {
            // Remove video
            // todo: Implement remove video event
        }

        return null;
    }

    protected function sendSlackChatMessage(SlackConversation $conversation, SlackUser $user, PlaylistVideo $video, VotePlaylistVideoCalculator $calculator)
    {
        try {
            $this->client->chatPostMessage([
                'channel' => '#' . $conversation->getName(),
                'username' => $this->translator->trans('name'),
                'blocks' => $this->createSlackBlock($user, $video, $calculator),
            ]);
        } catch (SlackErrorResponse $e) {
            $this->logger->error($e->getMessage());
        }
    }

    protected function createSlackBlock(SlackUser $user, PlaylistVideo $video, VotePlaylistVideoCalculator $calculator): string
    {
        return json_encode([
            [
                'type' => 'header',
                'text' => [
                    'type' => 'plain_text',
                    'text' => 'Remove vote for song: ' . $video->getTitle(),
                    'emoji' => true,
                ],
            ],
            [
                'type' => 'section',
                'text' => [
                    'type' => 'mrkdwn',
                    'text' => "{$calculator->getVotes()}/{$calculator->getRequiredVotes()} votes"
                        . $calculator->isFulfilled() ? "\n*Remove song*" : '',
                ],
            ],
            [
                'type' => 'section',
                'text' => [
                    'type' => 'mrkdwn',
                    'text' => "*Added by:*\n@{$user->getName()}",
                ],
            ],
        ]);
    }

}
