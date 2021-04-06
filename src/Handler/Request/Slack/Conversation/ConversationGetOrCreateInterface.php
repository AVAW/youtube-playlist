<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Conversation;

interface ConversationGetOrCreateInterface
{

    public function getChannelId(): string;

    public function getChannelName(): string;

}
