<?php

declare(strict_types=1);

namespace App\Entity\Vote;

use App\Entity\Playlist\PlaylistVideo;
use App\Repository\Vote\VotePlaylistVideoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class VotePlaylistVideo extends Vote
{

    const ACTION_REMOVE = 'remove';
    const ACTION_SKIP = 'skip';

    /**
     * @ORM\ManyToOne(targetEntity=PlaylistVideo::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private PlaylistVideo $video;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $action;

    public function getVideo(): ?PlaylistVideo
    {
        return $this->video;
    }

    public function setVideo(PlaylistVideo $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

}
