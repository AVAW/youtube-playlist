<?php

declare(strict_types=1);

namespace App\Model\Slack\Conversation;

use App\Handler\Request\Slack\Conversation\ConversationGetOrCreateInterface;

class ConversationGetOrCreateRequest implements ConversationGetOrCreateInterface
{

    protected string $channelId;
    protected string $channelName;

    public function getChannelId(): string
    {
        return $this->channelId;
    }

    public function setChannelId(string $channelId): self
    {
        $this->channelId = $channelId;

        return $this;
    }

    public function getChannelName(): string
    {
        return $this->channelName;
    }

    public function setChannelName(string $channelName): self
    {
        $this->channelName = $channelName;

        return $this;
    }

}
