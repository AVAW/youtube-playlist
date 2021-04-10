<?php

declare(strict_types=1);

namespace App\Entity\Slack;

use App\Repository\Slack\CommandRepository;
use App\Utils\Timestampable\Timestampable;
use App\Utils\Timestampable\TimestampableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\UuidV4;

/**
 * @ORM\Entity(repositoryClass=CommandRepository::class)
 */
class Command implements \Stringable, TimestampableInterface
{

    use Timestampable;

    const NAME_AMOUNT = '/amount';
    const NAME_BLAME = '/blame';
    const NAME_COMMANDS = '/commands';
    const NAME_NEXT = '/next';
    const NAME_PLAY = '/play';
    const NAME_SKIP = '/skip';
    const NAME_SONG = '/song';
    const NAME_START = '/start';
    const NAME_STOP = '/stop';
    const NAME_VOL_DOWN = '/voldown';
    const NAME_VOL_UP = '/volup';

    const NAME_VALUES = [
        self::NAME_AMOUNT,
        self::NAME_BLAME,
        self::NAME_COMMANDS,
        self::NAME_NEXT,
        self::NAME_PLAY,
        self::NAME_SKIP,
        self::NAME_SONG,
        self::NAME_START,
        self::NAME_STOP,
        self::NAME_VOL_DOWN,
        self::NAME_VOL_UP,
    ];

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
     * @ORM\Column(type="string", length=255)
     * @Groups({"playlist"})
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private ?string $text;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"playlist"})
     */
    private Team $team;

    /**
     * @ORM\ManyToOne(targetEntity=Conversation::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"playlist"})
     */
    private Conversation $conversation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"playlist"})
     */
    private User $user;

    public function __toString(): string
    {
        return __CLASS__ . ' ' . $this->getName();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function setTeam(Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getConversation(): Conversation
    {
        return $this->conversation;
    }

    public function setConversation(Conversation $conversation): self
    {
        $this->conversation = $conversation;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
