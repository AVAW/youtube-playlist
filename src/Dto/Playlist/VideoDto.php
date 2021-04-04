<?php

declare(strict_types=1);

namespace App\Dto\Playlist;

class VideoDto
{

    public string $id;
    public string $title;
    public \DateTimeInterface $publishedAt;

    public function __construct(
        string $id,
        string $title,
        \DateTimeInterface $publishedAt
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->publishedAt = $publishedAt;
    }

}
