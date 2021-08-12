<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Interactivity;

use App\Entity\Slack\SlackAction;
use App\Handler\Request\Playlist\Video\VideoVoteRemoveRequestHandler;
use App\Model\Playlist\Video\VideoVoteRemoveRequest;

class InteractivityPlaylistVideoRemove implements InteractivityInterface
{

    private VideoVoteRemoveRequestHandler $videoVoteRemoveRequestHandler;

    public function __construct(
        VideoVoteRemoveRequestHandler $videoVoteRemoveRequestHandler
    ) {
        $this->videoVoteRemoveRequestHandler = $videoVoteRemoveRequestHandler;
    }

    public function supports(SlackAction $action): bool
    {
        return $action->getActionId() === SlackAction::ACTION_ID_CLICK_PLAYLIST_VIDEO_REMOVE;
    }

    public function handle(SlackAction $action): ?string
    {
        $command = VideoVoteRemoveRequest::create(
            $action->getUser()->getUser(),
            $action->getValue(),
            $action->getCreatedAt(),
        );

        return $this->videoVoteRemoveRequestHandler->handle($command);
    }

}
