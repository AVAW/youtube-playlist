<?php

declare(strict_types=1);

namespace App\Entity\Slack;

use App\Repository\Slack\SlackActionRepository;
use App\Utils\Timestampable\Timestampable;
use App\Utils\Timestampable\TimestampableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;

/**
 * @ORM\Entity(repositoryClass=SlackActionRepository::class)
 */
class SlackAction implements \Stringable, TimestampableInterface
{

    use Timestampable;

    const ACTION_ID_CLICK_PLAYLIST_VIDEO_SKIP = 'click-playlist-video-skip';
    const ACTION_ID_CLICK_PLAYLIST_VIDEO_REMOVE = 'click-playlist-video-remove';

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
     * @ORM\Column(type="string", length=255)
     */
    private string $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $actionId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $value;

    /**
     * @ORM\ManyToOne(targetEntity=SlackTeam::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private SlackTeam $team;

    /**
     * @ORM\ManyToOne(targetEntity=SlackConversation::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private SlackConversation $conversation;

    /**
     * @ORM\ManyToOne(targetEntity=SlackUser::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private SlackUser $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $triggerId;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $enterprise;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isEnterpriseInstall;

    /**
     * @ORM\Column(type="string", length=1023)
     */
    private string $responseUrl;

    public function __toString()
    {
        return __CLASS__ . '__' . $this->getActionId();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getActionId(): ?string
    {
        return $this->actionId;
    }

    public function setActionId(string $actionId): self
    {
        $this->actionId = $actionId;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getTeam(): SlackTeam
    {
        return $this->team;
    }

    public function setTeam(SlackTeam $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getConversation(): SlackConversation
    {
        return $this->conversation;
    }

    public function setConversation(SlackConversation $conversation): self
    {
        $this->conversation = $conversation;

        return $this;
    }

    public function getUser(): ?SlackUser
    {
        return $this->user;
    }

    public function setUser(SlackUser $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTriggerId(): ?string
    {
        return $this->triggerId;
    }

    public function setTriggerId(string $triggerId): self
    {
        $this->triggerId = $triggerId;

        return $this;
    }

    public function getEnterprise(): ?bool
    {
        return $this->enterprise;
    }

    public function setEnterprise(?bool $enterprise): self
    {
        $this->enterprise = $enterprise;

        return $this;
    }

    public function getIsEnterpriseInstall(): ?bool
    {
        return $this->isEnterpriseInstall;
    }

    public function setIsEnterpriseInstall(bool $isEnterpriseInstall): self
    {
        $this->isEnterpriseInstall = $isEnterpriseInstall;

        return $this;
    }

    public function getResponseUrl(): ?string
    {
        return $this->responseUrl;
    }

    public function setResponseUrl(string $responseUrl): self
    {
        $this->responseUrl = $responseUrl;

        return $this;
    }

}
