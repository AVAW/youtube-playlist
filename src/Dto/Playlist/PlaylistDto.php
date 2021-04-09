<?php

declare(strict_types=1);

namespace App\Dto\Playlist;

class PlaylistDto
{

    public string $title;
    public string $description;
    public \DateTimeInterface $publishedAt;
    public string $channelTitle;

    public function __construct(
        string $title,
        string $description,
        \DateTimeInterface $publishedAt,
        string $channelTitle
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->publishedAt = $publishedAt;
        $this->channelTitle = $channelTitle;
    }

}
