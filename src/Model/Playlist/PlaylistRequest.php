<?php

declare(strict_types=1);

namespace App\Model\Playlist;

class PlaylistRequest implements PlaylistUuidInterface
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
