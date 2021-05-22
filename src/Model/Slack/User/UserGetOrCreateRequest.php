<?php

declare(strict_types=1);

namespace App\Model\Slack\User;

use App\Handler\Request\Slack\User\UserGetOrCreateInterface;

class UserGetOrCreateRequest implements UserGetOrCreateInterface
{

    protected string $userId;
    protected string $userName;

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }


}
