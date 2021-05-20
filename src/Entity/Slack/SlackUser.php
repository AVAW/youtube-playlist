<?php

declare(strict_types=1);

namespace App\Entity\Slack;

use App\Entity\Playlist\PlaylistVideo;
use App\Entity\User\User;
use App\Repository\Slack\SlackUserRepository;
use App\Utils\Timestampable\Timestampable;
use App\Utils\Timestampable\TimestampableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\UuidV4;

/**
 * @ORM\Entity(repositoryClass=SlackUserRepository::class)
 * @ORM\Table(indexes={@ORM\Index(name="identifier_idx", columns={"identifier"})})
 * @ORM\Table(indexes={@ORM\Index(name="email_idx", columns={"email"})})
 */
class SlackUser implements \Stringable, TimestampableInterface
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
     * @Groups({"playlist", "user"})
     */
    private UuidV4 $identifier;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $email;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private string $profileId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"playlist", "user"})
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"playlist", "user"})
     */
    private ?string $realName;

    /**
     * @ORM\ManyToOne(targetEntity=SlackTeam::class, inversedBy="users")
     */
    private ?SlackTeam $team;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"playlist", "user"})
     */
    private ?string $displayedName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user"})
     */
    private ?string $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $phone;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     * @Groups({"playlist", "user"})
     */
    private ?string $imageOriginalUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $lastName;

    /**
     * @ORM\ManyToMany(targetEntity=SlackConversation::class, inversedBy="users")
     */
    private Collection $conversations;

    /**
     * @ORM\OneToOne(targetEntity=SlackUserPresence::class, inversedBy="user", cascade={"persist", "remove"})
     * @Groups({"user"})
     */
    private ?SlackUserPresence $presence;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"user"})
     */
    private ?bool $isAdmin;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isAppUser;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"user"})
     */
    private ?bool $isBot;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isExternal;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isForgotten;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isInvitedUser;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isOwner;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isPrimaryOwner;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isRestricted;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isStranger;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isUltraRestricted;

    /**
     * @ORM\ManyToMany(targetEntity=PlaylistVideo::class, mappedBy="authors")
     */
    private Collection $playlistVideos;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="slackProfile")
     */
    private ?User $user;

    public function __construct()
    {
        $this->conversations = new ArrayCollection();
        $this->presence = null;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getProfileId(): ?string
    {
        return $this->profileId;
    }

    public function setProfileId(string $profileId): self
    {
        $this->profileId = $profileId;

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

    public function getRealName(): ?string
    {
        return $this->realName;
    }

    public function setRealName(?string $realName): self
    {
        $this->realName = $realName;

        return $this;
    }

    public function getTeam(): ?SlackTeam
    {
        return $this->team;
    }

    public function setTeam(?SlackTeam $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getDisplayedName(): ?string
    {
        return $this->displayedName;
    }

    public function setDisplayedName(?string $displayedName): self
    {
        $this->displayedName = $displayedName;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getImageOriginalUrl(): ?string
    {
        return $this->imageOriginalUrl;
    }

    public function setImageOriginalUrl(?string $imageOriginalUrl): self
    {
        $this->imageOriginalUrl = $imageOriginalUrl;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection|SlackConversation[]
     */
    public function getConversations(): Collection
    {
        return $this->conversations;
    }

    public function addConversation(SlackConversation $channel): self
    {
        if (!$this->conversations->contains($channel)) {
            $this->conversations[] = $channel;
        }

        return $this;
    }

    public function removeConversation(SlackConversation $channel): self
    {
        $this->conversations->removeElement($channel);

        return $this;
    }

    public function getPresence(): ?SlackUserPresence
    {
        return $this->presence;
    }

    public function setPresence(?SlackUserPresence $presence): self
    {
        $this->presence = $presence;

        return $this;
    }

    public function getIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(?bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function getIsAppUser(): ?bool
    {
        return $this->isAppUser;
    }

    public function setIsAppUser(?bool $isAppUser): self
    {
        $this->isAppUser = $isAppUser;

        return $this;
    }

    public function getIsBot(): ?bool
    {
        return $this->isBot;
    }

    public function setIsBot(?bool $isBot): self
    {
        $this->isBot = $isBot;

        return $this;
    }

    public function getIsExternal(): ?bool
    {
        return $this->isExternal;
    }

    public function setIsExternal(?bool $isExternal): self
    {
        $this->isExternal = $isExternal;

        return $this;
    }

    public function getIsForgotten(): ?bool
    {
        return $this->isForgotten;
    }

    public function setIsForgotten(?bool $isForgotten): self
    {
        $this->isForgotten = $isForgotten;

        return $this;
    }

    public function getIsInvitedUser(): ?bool
    {
        return $this->isInvitedUser;
    }

    public function setIsInvitedUser(?bool $isInvitedUser): self
    {
        $this->isInvitedUser = $isInvitedUser;

        return $this;
    }

    public function getIsOwner(): ?bool
    {
        return $this->isOwner;
    }

    public function setIsOwner(?bool $isOwner): self
    {
        $this->isOwner = $isOwner;

        return $this;
    }

    public function getIsPrimaryOwner(): ?bool
    {
        return $this->isPrimaryOwner;
    }

    public function setIsPrimaryOwner(?bool $isPrimaryOwner): self
    {
        $this->isPrimaryOwner = $isPrimaryOwner;

        return $this;
    }

    public function getIsRestricted(): ?bool
    {
        return $this->isRestricted;
    }

    public function setIsRestricted(?bool $isRestricted): self
    {
        $this->isRestricted = $isRestricted;

        return $this;
    }

    public function getIsStranger(): ?bool
    {
        return $this->isStranger;
    }

    public function setIsStranger(?bool $isStranger): self
    {
        $this->isStranger = $isStranger;

        return $this;
    }

    public function getIsUltraRestricted(): ?bool
    {
        return $this->isUltraRestricted;
    }

    public function setIsUltraRestricted(?bool $isUltraRestricted): self
    {
        $this->isUltraRestricted = $isUltraRestricted;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
