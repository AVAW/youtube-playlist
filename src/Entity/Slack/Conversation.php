<?php

declare(strict_types=1);

namespace App\Entity\Slack;

use App\Repository\Slack\ConversationRepository;
use App\Utils\Timestampable\Timestampable;
use App\Utils\Timestampable\TimestampableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\UuidV4;

/**
 * @ORM\Entity(repositoryClass=ConversationRepository::class)
 */
class Conversation implements \Stringable, TimestampableInterface
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
    private string $conversationId;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"playlist"})
     */
    private string $name;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="conversations")
     */
    private Collection $users;

    /**
     * @ORM\ManyToMany(targetEntity=Team::class, inversedBy="conversations")
     */
    private Collection $teams;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $creatorId;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isArchived;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isChannel;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isExtShared;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isFrozen;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isGeneral;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isGlobalShared;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isGroup;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isIm;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isMoved;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isMpim;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isNonThreadable;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isOpen;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isOrgDefault;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isPrivate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isShared;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $purpose;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $topic;

    /**
     * @ORM\OneToMany(targetEntity=ConversationPlaylist::class, mappedBy="conversation", orphanRemoval=true)
     * @Groups({"playlist"})
     */
    private Collection $conversationPlaylists;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $locale;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->teams = new ArrayCollection();
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

    public function getConversationId(): ?string
    {
        return $this->conversationId;
    }

    public function setConversationId(string $conversationId): self
    {
        $this->conversationId = $conversationId;

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
            $user->addConversation($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeConversation($this);
        }

        return $this;
    }

    /**
     * @return Collection|Team[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        $this->teams->removeElement($team);

        return $this;
    }

    public function getCreatorId(): ?string
    {
        return $this->creatorId;
    }

    public function setCreatorId(?string $creatorId): self
    {
        $this->creatorId = $creatorId;

        return $this;
    }

    public function getIsArchived(): ?bool
    {
        return $this->isArchived;
    }

    public function setIsArchived(?bool $isArchived): self
    {
        $this->isArchived = $isArchived;

        return $this;
    }

    public function getIsChannel(): ?bool
    {
        return $this->isChannel;
    }

    public function setIsChannel(?bool $isChannel): self
    {
        $this->isChannel = $isChannel;

        return $this;
    }

    public function getIsExtShared(): ?bool
    {
        return $this->isExtShared;
    }

    public function setIsExtShared(?bool $isExtShared): self
    {
        $this->isExtShared = $isExtShared;

        return $this;
    }

    public function getIsFrozen(): ?bool
    {
        return $this->isFrozen;
    }

    public function setIsFrozen(?bool $isFrozen): self
    {
        $this->isFrozen = $isFrozen;

        return $this;
    }

    public function getIsGeneral(): ?bool
    {
        return $this->isGeneral;
    }

    public function setIsGeneral(?bool $isGeneral): self
    {
        $this->isGeneral = $isGeneral;

        return $this;
    }

    public function getIsGlobalShared(): ?bool
    {
        return $this->isGlobalShared;
    }

    public function setIsGlobalShared(?bool $isGlobalShared): self
    {
        $this->isGlobalShared = $isGlobalShared;

        return $this;
    }

    public function getIsGroup(): ?bool
    {
        return $this->isGroup;
    }

    public function setIsGroup(?bool $isGroup): self
    {
        $this->isGroup = $isGroup;

        return $this;
    }

    public function getIsIm(): ?bool
    {
        return $this->isIm;
    }

    public function setIsIm(?bool $isIm): self
    {
        $this->isIm = $isIm;

        return $this;
    }

    public function getIsMoved(): ?bool
    {
        return $this->isMoved;
    }

    public function setIsMoved(?bool $isMoved): self
    {
        $this->isMoved = $isMoved;

        return $this;
    }

    public function getIsMpim(): ?bool
    {
        return $this->isMpim;
    }

    public function setIsMpim(?bool $isMpim): self
    {
        $this->isMpim = $isMpim;

        return $this;
    }

    public function getIsNonThreadable(): ?bool
    {
        return $this->isNonThreadable;
    }

    public function setIsNonThreadable(?bool $isNonThreadable): self
    {
        $this->isNonThreadable = $isNonThreadable;

        return $this;
    }

    public function getIsOpen(): ?bool
    {
        return $this->isOpen;
    }

    public function setIsOpen(?bool $isOpen): self
    {
        $this->isOpen = $isOpen;

        return $this;
    }

    public function getIsOrgDefault(): ?bool
    {
        return $this->isOrgDefault;
    }

    public function setIsOrgDefault(?bool $isOrgDefault): self
    {
        $this->isOrgDefault = $isOrgDefault;

        return $this;
    }

    public function getIsPrivate(): ?bool
    {
        return $this->isPrivate;
    }

    public function setIsPrivate(?bool $isPrivate): self
    {
        $this->isPrivate = $isPrivate;

        return $this;
    }

    public function getIsShared(): ?bool
    {
        return $this->isShared;
    }

    public function setIsShared(?bool $isShared): self
    {
        $this->isShared = $isShared;

        return $this;
    }

    public function getPurpose(): ?string
    {
        return $this->purpose;
    }

    public function setPurpose(?string $purpose): self
    {
        $this->purpose = $purpose;

        return $this;
    }

    public function getTopic(): ?string
    {
        return $this->topic;
    }

    public function setTopic(string $topic): self
    {
        $this->topic = $topic;

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
            $conversationPlaylist->setConversation($this);
        }

        return $this;
    }

    public function removeConversationPlaylist(ConversationPlaylist $conversationPlaylist): self
    {
        if ($this->conversationPlaylists->removeElement($conversationPlaylist)) {
            // set the owning side to null (unless already changed)
            if ($conversationPlaylist->getConversation() === $this) {
                $conversationPlaylist->setConversation(null);
            }
        }

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

}
