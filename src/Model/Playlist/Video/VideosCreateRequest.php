<?php

declare(strict_types=1);

namespace App\Model\Playlist\Video;

use App\Handler\Request\Playlist\Video\VideosCreateInterface;

class VideosCreateRequest implements VideosCreateInterface
{

    private array $videos;

    public static function create(array $videos): self
    {
        return (new static)
            ->setVideos($videos);
    }

    public function getVideos(): array
    {
        return $this->videos;
    }

    public function setVideos(array $videos): self
    {
        $this->videos = $videos;

        return $this;
    }


}
