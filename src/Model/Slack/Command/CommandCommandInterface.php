<?php

declare(strict_types=1);

namespace App\Model\Slack\Command;

interface CommandCommandInterface
{

    public function getCommand(): string;

    public function getText(): ?string;

}
