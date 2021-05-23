<?php

declare(strict_types=1);

namespace App\Entity\Slack;

use App\Entity\Playlist\Playlist;
use App\Repository\Slack\SlackConversationPlaylistRepository;
use App\Utils\Timestampable\Timestampable;
use App\Utils\Timestampable\TimestampableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;

/**
 * @ORM\Entity(repositoryClass=SlackConversationPlaylistRepository::class)
 * @ORM\Table(indexes={@ORM\Index(name="idx_identifier", columns={"identifier"})})
 */
class SlackConversationPlaylist implements \Stringable, TimestampableInterface
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
     * @ORM\ManyToOne(targetEntity=SlackConversation::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private SlackConversation $conversation;

    /**
     * @ORM\ManyToOne(targetEntity=Playlist::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private Playlist $playlist;

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

    public function getConversation(): SlackConversation
    {
        return $this->conversation;
    }

    public function setConversation(SlackConversation $conversation): self
    {
        $this->conversation = $conversation;

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

}
