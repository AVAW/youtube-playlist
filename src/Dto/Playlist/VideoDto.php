<?php

declare(strict_types=1);

namespace App\Dto\Playlist;

class VideoDto
{

    public string $id;
    public string $title;
    public \DateTimeInterface $publishedAt;
    public ?string $videoOwnerChannelId;
    public ?string $videoOwnerChannelTitle;

    public function __construct(
        string $id,
        string $title,
        \DateTimeInterface $publishedAt,
        ?string $videoOwnerChannelId,
        ?string $videoOwnerChannelTitle
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->publishedAt = $publishedAt;
        $this->videoOwnerChannelId = $videoOwnerChannelId;
        $this->videoOwnerChannelTitle = $videoOwnerChannelTitle;
    }

}
