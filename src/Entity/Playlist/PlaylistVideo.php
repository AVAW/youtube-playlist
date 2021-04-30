<?php

declare(strict_types=1);

namespace App\Entity\Playlist;

use App\Entity\Slack\SlackUser;
use App\Repository\Playlist\PlaylistVideoRepository;
use App\Utils\Timestampable\Timestampable;
use App\Utils\Timestampable\TimestampableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\UuidV4;

/**
 * @ORM\Entity(repositoryClass=PlaylistVideoRepository::class)
 */
class PlaylistVideo implements \Stringable, TimestampableInterface
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
     * @Groups({"playlist"})
     */
    private UuidV4 $identifier;

    /**
     * @ORM\ManyToOne(targetEntity=Playlist::class, inversedBy="videos", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private Playlist $playlist;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"playlist"})
     */
    private string $videoId;

    /**
     * @ORM\Column(type="string", length=512)
     * @Groups({"playlist"})
     */
    private string $title;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"playlist"})
     */
    private \DateTimeInterface $publishedAt;

    /**
     * @ORM\ManyToMany(targetEntity=SlackUser::class, inversedBy="videos")
     * @Groups({"playlist"})
     */
    private Collection $authors;

    /**
     * @ORM\OneToMany(targetEntity=PlaylistPlay::class, mappedBy="video", orphanRemoval=true)
     */
    private Collection $plays;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
        $this->plays = new ArrayCollection();
    }

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

    public function getPlaylist(): Playlist
    {
        return $this->playlist;
    }

    public function setPlaylist(Playlist $playlist): self
    {
        $this->playlist = $playlist;

        return $this;
    }

    public function getVideoId(): ?string
    {
        return $this->videoId;
    }

    public function setVideoId(string $videoId): self
    {
        $this->videoId = $videoId;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * @return Collection|SlackUser[]
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(SlackUser $author): self
    {
        if (!$this->authors->contains($author)) {
            $this->authors[] = $author;
        }

        return $this;
    }

    public function removeAuthor(SlackUser $author): self
    {
        $this->authors->removeElement($author);

        return $this;
    }

    /**
     * @return Collection|PlaylistPlay[]
     */
    public function getPlays(): Collection
    {
        return $this->plays;
    }

    public function addPlay(PlaylistPlay $play): self
    {
        if (!$this->plays->contains($play)) {
            $this->plays[] = $play;
            $play->setVideo($this);
        }

        return $this;
    }

    public function removePlay(PlaylistPlay $play): self
    {
        if ($this->plays->removeElement($play)) {
            // set the owning side to null (unless already changed)
            if ($play->getVideo() === $this) {
                $play->setVideo(null);
            }
        }

        return $this;
    }

}
