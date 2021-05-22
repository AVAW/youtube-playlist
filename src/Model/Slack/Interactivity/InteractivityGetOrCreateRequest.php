<?php

declare(strict_types=1);

namespace App\Model\Slack\Interactivity;

use App\Handler\Request\Slack\Action\ActionCollectionCreateInterface;
use App\Model\Slack\Action\ActionCreateRequest;
use App\Model\Slack\Conversation\ConversationGetOrCreateRequest;
use App\Model\Slack\Team\TeamGetOrCreateRequest;
use App\Model\Slack\User\UserGetOrCreateRequest;

class InteractivityGetOrCreateRequest implements ActionCollectionCreateInterface
{

    protected string $type;
    protected string $token;
    protected string $triggerId;
    protected ?string $enterprise = null;
    protected bool $isEnterpriseInstall = false;
    protected string $responseUrl;
    protected TeamGetOrCreateRequest $team;
    protected ConversationGetOrCreateRequest $conversation;
    protected UserGetOrCreateRequest $user;
    /** @var array|ActionCreateRequest[] */
    protected array $actions;

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getTriggerId(): string
    {
        return $this->triggerId;
    }

    public function setTriggerId(string $triggerId): self
    {
        $this->triggerId = $triggerId;

        return $this;
    }

    public function getEnterprise(): ?string
    {
        return $this->enterprise;
    }

    public function setEnterprise(?string $enterprise): self
    {
        $this->enterprise = $enterprise;

        return $this;
    }

    public function isEnterpriseInstall(): bool
    {
        return $this->isEnterpriseInstall;
    }

    public function setIsEnterpriseInstall(bool $isEnterpriseInstall): self
    {
        $this->isEnterpriseInstall = $isEnterpriseInstall;

        return $this;
    }

    public function getResponseUrl(): string
    {
        return $this->responseUrl;
    }

    public function setResponseUrl(string $responseUrl): self
    {
        $this->responseUrl = $responseUrl;

        return $this;
    }

    public function getTeam(): TeamGetOrCreateRequest
    {
        return $this->team;
    }

    public function setTeam(TeamGetOrCreateRequest $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getConversation(): ConversationGetOrCreateRequest
    {
        return $this->conversation;
    }

    public function setConversation(ConversationGetOrCreateRequest $conversation): self
    {
        $this->conversation = $conversation;

        return $this;
    }

    public function getUser(): UserGetOrCreateRequest
    {
        return $this->user;
    }

    public function setUser(UserGetOrCreateRequest $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getActions(): array
    {
        return $this->actions;
    }

    public function setActions(array $actions): self
    {
        $this->actions = $actions;

        return $this;
    }

}
