<?php

declare(strict_types=1);

namespace App\Dto\Playlist;

class PlaylistDto
{

    public ?string $title;
    public ?string $description;
    public ?\DateTimeInterface $publishedAt;
    public ?string $channelTitle;

    public function __construct(
        string $title = null,
        string $description = null,
        \DateTimeInterface $publishedAt = null,
        string $channelTitle = null
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->publishedAt = $publishedAt;
        $this->channelTitle = $channelTitle;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setPublishedAt(?\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function setChannelTitle(?string $channelTitle): self
    {
        $this->channelTitle = $channelTitle;

        return $this;
    }


}
