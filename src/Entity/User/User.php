<?php

declare(strict_types=1);

namespace App\Entity\User;

use App\Entity\Google\GoogleUser;
use App\Entity\Playlist\PlaylistVideo;
use App\Entity\Slack\SlackUser;
use App\Repository\User\UserRepository;
use App\Utils\Timestampable\Timestampable;
use App\Utils\Timestampable\TimestampableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\UuidV4;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"login"}, message="There is already an account with this login")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @ORM\Table(indexes={@ORM\Index(name="idx_identifier", columns={"identifier"})})
 * @ORM\Table(indexes={@ORM\Index(name="idx_email", columns={"email"})})
 */
class User implements UserInterface, \Stringable, TimestampableInterface
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var null|string The hashed password
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $login;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isVerified;

    /**
     * @ORM\ManyToMany(targetEntity=PlaylistVideo::class, mappedBy="authors")
     */
    private Collection $playlistVideos;

    /**
     * @ORM\OneToOne(targetEntity=SlackUser::class, inversedBy="user", cascade={"persist", "remove"})
     */
    private ?SlackUser $slackUser;

    /**
     * @ORM\OneToOne(targetEntity=GoogleUser::class, inversedBy="user", cascade={"persist", "remove"})
     */
    private ?GoogleUser $googleUser;

    public function __construct()
    {
        $this->isVerified = false;
        $this->playlistVideos = new ArrayCollection();
    }

    public function __toString(): string
    {
        return __CLASS__ . '__' . $this->getId() . '__' . $this->getUsername();
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->login;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return (string) $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(?string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection|PlaylistVideo[]
     */
    public function getPlaylistVideos(): Collection
    {
        return $this->playlistVideos;
    }

    public function addPlaylistVideo(PlaylistVideo $playlistVideo): self
    {
        if (!$this->playlistVideos->contains($playlistVideo)) {
            $this->playlistVideos[] = $playlistVideo;
            $playlistVideo->addAuthor($this);
        }

        return $this;
    }

    public function removePlaylistVideo(PlaylistVideo $playlistVideo): self
    {
        if ($this->playlistVideos->removeElement($playlistVideo)) {
            $playlistVideo->removeAuthor($this);
        }

        return $this;
    }

    public function getSlackUser(): ?SlackUser
    {
        return $this->slackUser;
    }

    public function setSlackUser(?SlackUser $SlackUser): self
    {
        $this->slackUser = $SlackUser;

        return $this;
    }

    public function getGoogleUser(): ?GoogleUser
    {
        return $this->googleUser;
    }

    public function setGoogleUser(?GoogleUser $googleUser): self
    {
        $this->googleUser = $googleUser;

        return $this;
    }

}
