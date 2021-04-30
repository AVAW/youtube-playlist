<?php

declare(strict_types=1);

namespace App\Entity\Playlist;

use App\Repository\Playlist\PlaylistPlayRepository;
use App\Utils\Timestampable\Timestampable;
use App\Utils\Timestampable\TimestampableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;

/**
 * @ORM\Entity(repositoryClass=PlaylistPlayRepository::class)
 * @ORM\Table(indexes={@ORM\Index(name="identifier_idx", columns={"identifier"})})
 */
class PlaylistPlay implements \Stringable, TimestampableInterface
{

    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="uuid")
     */
    private UuidV4 $identifier;

    /**
     * @ORM\ManyToOne(targetEntity=Playlist::class, inversedBy="plays")
     * @ORM\JoinColumn(nullable=false)
     */
    private Playlist $playlist;

    /**
     * @ORM\ManyToOne(targetEntity=PlaylistVideo::class, inversedBy="plays")
     * @ORM\JoinColumn(nullable=false)
     */
    private PlaylistVideo $video;

    public function __toString(): string
    {
        return __CLASS__ . '__' . $this->getId();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifier(): UuidV4
    {
        return $this->identifier;
    }

    public function setIdentifier(UuidV4 $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getPlaylist(): ?Playlist
    {
        return $this->playlist;
    }

    public function setPlaylist(Playlist $playlist): self
    {
        $this->playlist = $playlist;

        return $this;
    }

    public function getVideo(): ?PlaylistVideo
    {
        return $this->video;
    }

    public function setVideo(PlaylistVideo $video): self
    {
        $this->video = $video;

        return $this;
    }

}
