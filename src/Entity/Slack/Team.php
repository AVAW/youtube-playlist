<?php

declare(strict_types=1);

namespace App\Entity\Slack;

use App\Repository\Slack\TeamRepository;
use App\Utils\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team implements \Stringable
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
    private string $teamId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $domain;

    public function __toString(): string
    {
        return __CLASS__ . '_' . $this->getId();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamId(): ?string
    {
        return $this->teamId;
    }

    public function setTeamId(string $teamId): self
    {
        $this->teamId = $teamId;

        return $this;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

}
