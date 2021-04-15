<?php

namespace App\Entity\Slack;

use App\Entity\Playlist\PlaylistVideo;
use App\Repository\Slack\ConversationPlaylistVideoRepository;
use App\Utils\Timestampable\Timestampable;
use App\Utils\Timestampable\TimestampableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;

/**
 * @ORM\Entity(repositoryClass=ConversationPlaylistVideoRepository::class)
 */
class ConversationPlaylistVideo implements \Stringable, TimestampableInterface
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
     * @ORM\OneToOne(targetEntity=ConversationPlaylist::class, inversedBy="conversationPlaylistVideo", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private ConversationPlaylist $conversationPlaylist;

    /**
     * @ORM\OneToOne(targetEntity=PlaylistVideo::class, cascade={"persist", "remove"})
     */
    private ?PlaylistVideo $currentVideo;

    public function __toString(): string
    {
        return __CLASS__ . ' ' . $this->getId();
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

    public function getConversationPlaylist(): ConversationPlaylist
    {
        return $this->conversationPlaylist;
    }

    public function setConversationPlaylist(ConversationPlaylist $conversationPlaylist): self
    {
        $this->conversationPlaylist = $conversationPlaylist;

        return $this;
    }

    public function getCurrentVideo(): ?PlaylistVideo
    {
        return $this->currentVideo;
    }

    public function setCurrentVideo(?PlaylistVideo $currentVideo): self
    {
        $this->currentVideo = $currentVideo;

        return $this;
    }

}
