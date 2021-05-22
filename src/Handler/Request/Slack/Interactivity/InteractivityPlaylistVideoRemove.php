<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Interactivity;

use App\Entity\Slack\SlackAction;

class InteractivityPlaylistVideoRemove implements InteractivityInterface
{

    public function supports(SlackAction $action): bool
    {
        return $action->getActionId() === SlackAction::ACTION_ID_CLICK_PLAYLIST_VIDEO_REMOVE;
    }

    public function handle(SlackAction $action)
    {
        // TODO: Implement handle() method.
    }

}
