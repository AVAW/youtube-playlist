<?php

declare(strict_types=1);

namespace App\Model\Playlist;

use App\Handler\Request\Playlist\PlaylistCreateInterface;

class PlaylistCreateRequest implements PlaylistCreateInterface
{

    protected string $url;

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

}
