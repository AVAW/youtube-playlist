<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Command;

interface CommandCreateInterface
{

    public function getCommand(): string;

    public function getText(): ?string;

}
