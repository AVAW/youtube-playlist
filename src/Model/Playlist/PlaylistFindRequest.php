<?php

declare(strict_types=1);

namespace App\Model\Playlist;

use App\Handler\Request\Playlist\PlaylistFindInterface;

class PlaylistFindRequest implements PlaylistFindInterface
{

    private string $uuid;

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid($uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

}
