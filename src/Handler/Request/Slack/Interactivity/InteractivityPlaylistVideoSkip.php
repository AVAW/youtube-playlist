<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Interactivity;

use App\Entity\Slack\SlackAction;
use App\Handler\Request\Playlist\Video\VideoVoteSkipRequestHandler;
use App\Model\Playlist\Video\VideoVoteSkipRequest;

class InteractivityPlaylistVideoSkip implements InteractivityInterface
{

    private VideoVoteSkipRequestHandler $videoVoteSkipRequestHandler;

    public function __construct(
        VideoVoteSkipRequestHandler $videoVoteSkipRequestHandler
    ) {
        $this->videoVoteSkipRequestHandler = $videoVoteSkipRequestHandler;
    }

    public function supports(SlackAction $action): bool
    {
        return $action->getActionId() === SlackAction::ACTION_ID_CLICK_PLAYLIST_VIDEO_SKIP;
    }

    public function handle(SlackAction $action): ?string
    {
        $command = VideoVoteSkipRequest::create(
            $action->getUser()->getUser(),
            $action->getValue(),
            $action->getCreatedAt(),
        );

        return $this->videoVoteSkipRequestHandler->handle($command);
    }

}
