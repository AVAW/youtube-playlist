<?php

declare(strict_types=1);

namespace App\Entity\Vote;

use App\Entity\User\User;
use App\Repository\Vote\VoteRepository;
use App\Utils\Timestampable\Timestampable;
use App\Utils\Timestampable\TimestampableInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;
use Symfony\Component\Uid\UuidV4;

/**
 * @ORM\Entity(repositoryClass=VoteRepository::class)
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="type", type="string")
 * @DiscriminatorMap({"playlist-video" = "VotePlaylistVideo"})
 */
abstract class Vote implements \Stringable, TimestampableInterface
{

    use Timestampable;

    const USER = 'asdf';

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
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $votedAt;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getVotedAt(): ?\DateTimeInterface
    {
        return $this->votedAt;
    }

    public function setVotedAt(\DateTimeInterface $votedAt): self
    {
        $this->votedAt = $votedAt;

        return $this;
    }

}
