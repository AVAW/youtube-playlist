<?php

declare(strict_types=1);

namespace App\Model\Slack\SlashCommands;

use App\Handler\Request\Slack\Command\CommandCreateInterface;
use App\Model\Slack\Conversation\ConversationGetOrCreateRequest;
use App\Model\Slack\Team\TeamGetOrCreateRequest;
use App\Model\Slack\User\UserGetOrCreateRequest;

class GetOrCreateRequest implements CommandCreateInterface
{

    protected string $token;
    protected TeamGetOrCreateRequest $team;
    protected ConversationGetOrCreateRequest $conversation;
    protected UserGetOrCreateRequest $user;
    protected string $command;
    protected ?string $text = null;

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken($token): self
    {
        $this->token = $token;

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

    public function getCommand(): string
    {
        return $this->command;
    }

    public function setCommand(string $command): self
    {
        $this->command = $command;

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

}
