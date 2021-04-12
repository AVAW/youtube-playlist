<?php

declare(strict_types=1);

namespace App\Entity\Slack;

use App\Repository\Slack\UserPresenceRepository;
use App\Utils\Timestampable\Timestampable;
use App\Utils\Timestampable\TimestampableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserPresenceRepository::class)
 */
class UserPresence implements \Stringable, TimestampableInterface
{

    use Timestampable;

    const PRESENCE_ACTIVE = 'active';
    const PRESENCE_AWAY = 'away';

    const PRESENCE_VALUES = [
        self::PRESENCE_ACTIVE,
        self::PRESENCE_AWAY
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $autoAway;

    /**
     * @ORM\Column(type="integer", length=255, nullable=true)
     */
    private ?int $connectionCount;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $manualAway;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $online;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $presence;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="presence", cascade={"persist", "remove"})
     */
    private ?User $user;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?\DateTimeInterface $lastActivity;

    public function __toString(): string
    {
        return __CLASS__ . ' ' . $this->getId();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAutoAway(): ?bool
    {
        return $this->autoAway;
    }

    public function setAutoAway(?bool $autoAway): self
    {
        $this->autoAway = $autoAway;

        return $this;
    }

    public function getConnectionCount(): ?int
    {
        return $this->connectionCount;
    }

    public function setConnectionCount(?int $connectionCount): self
    {
        $this->connectionCount = $connectionCount;

        return $this;
    }

    public function getManualAway(): ?bool
    {
        return $this->manualAway;
    }

    public function setManualAway(?bool $manualAway): self
    {
        $this->manualAway = $manualAway;

        return $this;
    }

    public function getOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(?bool $online): self
    {
        $this->online = $online;

        return $this;
    }

    public function getPresence(): ?string
    {
        return $this->presence;
    }

    public function setPresence(?string $presence): self
    {
        $this->presence = $presence;

        return $this;
    }

    /**
     * @Groups({"user"})
     */
    public function isActive(): bool
    {
        return $this->presence === static::PRESENCE_ACTIVE;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setPresence(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getPresence() !== $this) {
            $user->setPresence($this);
        }

        $this->user = $user;

        return $this;
    }

    public function getLastActivity(): ?\DateTimeInterface
    {
        return $this->lastActivity;
    }

    public function setLastActivity(?\DateTimeInterface $lastActivity): self
    {
        $this->lastActivity = $lastActivity;

        return $this;
    }

}
