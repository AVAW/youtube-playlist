<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\User;

interface UserGetOrCreateInterface
{

    public function getUserId(): string;

    public function getUserName(): string;

}
