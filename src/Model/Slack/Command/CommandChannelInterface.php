<?php

declare(strict_types=1);

namespace App\Model\Slack\Command;

interface CommandChannelInterface
{

    public function getChannelId(): string;

    public function getChannelName(): string;

}
