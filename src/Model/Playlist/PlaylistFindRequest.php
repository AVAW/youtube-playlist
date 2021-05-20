<?php

declare(strict_types=1);

namespace App\Model\Playlist;

use App\Handler\Request\Playlist\PlaylistFindInterface;

class PlaylistFindRequest implements PlaylistFindInterface
{

    private string $identifier;

    public static function create(
        string $identifier
    ): self {
        return (new static)
            ->setIdentifier($identifier);
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

}
