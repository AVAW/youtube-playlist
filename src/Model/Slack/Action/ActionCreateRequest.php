<?php

declare(strict_types=1);

namespace App\Model\Slack\Action;

use App\Handler\Request\Slack\Action\ActionCreateInterface;

class ActionCreateRequest implements ActionCreateInterface
{

    protected string $actionId;
    protected string $value;

    public function getActionId(): string
    {
        return $this->actionId;
    }

    public function setActionId(string $actionId): ActionCreateRequest
    {
        $this->actionId = $actionId;

        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): ActionCreateRequest
    {
        $this->value = $value;

        return $this;
    }

}
