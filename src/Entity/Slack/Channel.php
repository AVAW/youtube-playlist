<?php

declare(strict_types=1);

namespace App\Entity\Slack;

use App\Repository\Slack\ChannelRepository;
use App\Utils\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChannelRepository::class)
 */
class Channel implements \Stringable
{

    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private string $channelId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    public function __toString(): string
    {
        return __CLASS__ . '_' . $this->getId();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChannelId(): ?string
    {
        return $this->channelId;
    }

    public function setChannelId(string $channelId): self
    {
        $this->channelId = $channelId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

}
