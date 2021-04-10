<?php

declare(strict_types=1);

namespace App\Entity\Slack;

use App\Repository\Slack\TeamRepository;
use App\Utils\Timestampable\Timestampable;
use App\Utils\Timestampable\TimestampableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\UuidV4;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team implements \Stringable, TimestampableInterface
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
     * @ORM\Column(type="string", length=64)
     */
    private string $teamId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $domain;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="team")
     */
    private Collection $users;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"playlist"})
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $emailDomain;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"playlist"})
     */
    private ?string $iconUrl;

    /**
     * @ORM\ManyToMany(targetEntity=Conversation::class, mappedBy="teams")
     */
    private Collection $conversations;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->conversations = new ArrayCollection();
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

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setTeam($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getTeam() === $this) {
                $user->setTeam(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmailDomain(): ?string
    {
        return $this->emailDomain;
    }

    public function setEmailDomain(?string $emailDomain): self
    {
        $this->emailDomain = $emailDomain;

        return $this;
    }

    public function getIconUrl(): ?string
    {
        return $this->iconUrl;
    }

    public function setIconUrl(?string $iconUrl): self
    {
        $this->iconUrl = $iconUrl;

        return $this;
    }

    /**
     * @return Collection|Conversation[]
     */
    public function getConversations(): Collection
    {
        return $this->conversations;
    }

    public function addConversation(Conversation $channel): self
    {
        if (!$this->conversations->contains($channel)) {
            $this->conversations[] = $channel;
            $channel->addTeam($this);
        }

        return $this;
    }

    public function removeConversation(Conversation $channel): self
    {
        if ($this->conversations->removeElement($channel)) {
            $channel->removeTeam($this);
        }

        return $this;
    }

}
