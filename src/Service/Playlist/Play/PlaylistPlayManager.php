<?php

declare(strict_types=1);

namespace App\Service\Playlist\Play;

class PlaylistPlayManager
{

    private PlaylistPlayProvider $provider;

    public function __construct(
        PlaylistPlayProvider $playlistPlayProvider
    ) {
        $this->provider = $playlistPlayProvider;
    }


}
