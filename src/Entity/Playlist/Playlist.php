<?php

declare(strict_types=1);

namespace App\Entity\Playlist;

use App\Entity\Slack\Command;
use App\Entity\Slack\ConversationPlaylist;
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
 * @ORM\Table(indexes={@ORM\Index(name="identifier_index", columns={"identifier"})})
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
     * @Groups({"playlist"})
     */
    private UuidV4 $identifier;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    private string $url;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"playlist"})
     */
    private string $youtubeId;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"playlist"})
     */
    private ?\DateTimeInterface $publishedAt;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     * @Groups({"playlist"})
     */
    private ?string $title;

    /**
     * @ORM\Column(type="string", length=2048, nullable=true)
     * @Groups({"playlist"})
     */
    private ?string $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"playlist"})
     */
    private ?string $channelTitle;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"playlist"})
     */
    private ?int $videosAmount;

    // todo: remove eager, use query builder
    /**
     * @ORM\OneToMany(targetEntity=PlaylistVideo::class, mappedBy="playlist", orphanRemoval=true, fetch="EAGER")
     * @Groups({"playlist"})
     */
    private Collection $playlistVideos;

    /**
     * @ORM\OneToOne(targetEntity=Command::class, cascade={"persist", "remove"}, fetch="EAGER")
     * @Groups({"playlist"})
     */
    private ?Command $command;

    /**
     * @ORM\OneToMany(targetEntity=ConversationPlaylist::class, mappedBy="playlist")
     */
    private Collection $conversationPlaylists;

    public function __construct()
    {
        $this->playlistVideos = new ArrayCollection();
        $this->conversationPlaylists = new ArrayCollection();
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

    public function getCommand(): ?Command
    {
        return $this->command;
    }

    public function setCommand(?Command $command): self
    {
        $this->command = $command;

        return $this;
    }

    /**
     * @return Collection|ConversationPlaylist[]
     */
    public function getConversationPlaylists(): Collection
    {
        return $this->conversationPlaylists;
    }

    public function addConversationPlaylist(ConversationPlaylist $conversationPlaylist): self
    {
        if (!$this->conversationPlaylists->contains($conversationPlaylist)) {
            $this->conversationPlaylists[] = $conversationPlaylist;
            $conversationPlaylist->setPlaylist($this);
        }

        return $this;
    }

    public function removeConversationPlaylist(ConversationPlaylist $conversationPlaylist): self
    {
        if ($this->conversationPlaylists->removeElement($conversationPlaylist)) {
            // set the owning side to null (unless already changed)
            if ($conversationPlaylist->getPlaylist() === $this) {
                $conversationPlaylist->setPlaylist(null);
            }
        }

        return $this;
    }

}
