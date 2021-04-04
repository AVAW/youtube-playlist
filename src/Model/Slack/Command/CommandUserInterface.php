<?php

declare(strict_types=1);

namespace App\Model\Slack\Command;

interface CommandUserInterface
{

    public function getUserId(): string;

    public function getUserName(): string;

}
