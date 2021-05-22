<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Action;

interface ActionCreateInterface
{

    public function getActionId(): string;

    public function getValue(): string;

}
