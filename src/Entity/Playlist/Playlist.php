<?php

declare(strict_types=1);

namespace App\Entity\Playlist;

use App\Repository\Playlist\PlaylistRepository;
use App\Utils\Timestampable\Timestampable;
use App\Utils\Timestampable\TimestampableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\UuidV4;

/**
 * @ORM\Entity(repositoryClass=PlaylistRepository::class)
 */
class Playlist implements \Stringable, TimestampableInterface
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
     * @Groups({"simple"})
     */
    private UuidV4 $identifier;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    private string $url;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"simple"})
     */
    private string $youtubeId;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"simple"})
     */
    private ?\DateTimeInterface $publishedAt;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     * @Groups({"simple"})
     */
    private ?string $title;

    /**
     * @ORM\Column(type="string", length=2048, nullable=true)
     * @Groups({"simple"})
     */
    private ?string $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"simple"})
     */
    private ?string $channelTitle;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"simple"})
     */
    private ?int $videosAmount;

    /**
     * @ORM\OneToMany(targetEntity=PlaylistVideo::class, mappedBy="playlist", orphanRemoval=true, fetch="EAGER")
     * @Groups({"simple"})
     */
    private Collection $playlistVideos;

    public function __construct()
    {
        $this->playlistVideos = new ArrayCollection();
    }

    public function __toString(): string
    {
        return __CLASS__ . '_' . $this->getId();
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getYoutubeId(): string
    {
        return $this->youtubeId;
    }

    public function setYoutubeId(string $youtubeId): self
    {
        $this->youtubeId = $youtubeId;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getChannelTitle(): ?string
    {
        return $this->channelTitle;
    }

    public function setChannelTitle(?string $channelTitle): self
    {
        $this->channelTitle = $channelTitle;

        return $this;
    }

    public function getVideosAmount(): ?int
    {
        return $this->videosAmount;
    }

    public function setVideosAmount(?int $videosAmount): self
    {
        $this->videosAmount = $videosAmount;

        return $this;
    }

    /**
     * @return Collection|PlaylistVideo[]
     */
    public function getPlaylistVideos(): Collection
    {
        return $this->playlistVideos;
    }

    public function addPlaylistVideo(PlaylistVideo $video): self
    {
        if (!$this->playlistVideos->contains($video)) {
            $this->playlistVideos[] = $video;
            $video->setPlaylist($this);
        }

        return $this;
    }

    public function removePlaylistVideo(PlaylistVideo $video): self
    {
        if ($this->playlistVideos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getPlaylist() === $this) {
                $video->setPlaylist(null);
            }
        }

        return $this;
    }

}
