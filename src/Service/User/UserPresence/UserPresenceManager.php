<?php

declare(strict_types=1);

namespace App\Service\User\UserPresence;

use App\Entity\Playlist\Playlist;
use App\Entity\Slack\SlackConversationPlaylist;
use App\Service\Slack\ConversationPlaylist\SlackConversationPlaylistProvider;

class UserPresenceManager
{

    private SlackConversationPlaylistProvider $slackConversationPlaylistProvider;

    public function __construct(
        SlackConversationPlaylistProvider $slackConversationPlaylistProvider
    ) {
        $this->slackConversationPlaylistProvider  = $slackConversationPlaylistProvider;
    }

    public function getPresentUsers(Playlist $playlist): array
    {
        $presentUsers = [];

        $slackConversationPlaylist = $this->slackConversationPlaylistProvider->findByPlaylist($playlist);
        if ($slackConversationPlaylist instanceof SlackConversationPlaylist) {
            $slackConversation = $slackConversationPlaylist->getConversation();
            $slackUsers = $slackConversation->getUsers();

            foreach ($slackUsers as $slackUser) {
                $presence = $slackUser->getPresence();
                if ($presence->isActive()) {
                    $presentUsers [] = $slackUser->getUser();
                }
            }
        }

        return $presentUsers;
    }

}
