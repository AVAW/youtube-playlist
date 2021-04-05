<?php

declare(strict_types=1);

namespace App\Service\Playlist;

use App\Entity\Playlist;
use App\Repository\PlaylistRepository;

class PlaylistManager
{

    protected PlaylistProvider $provider;

    public function __construct(PlaylistProvider $provider)
    {
        $this->provider = $provider;
    }

}
