<?php

declare(strict_types=1);

namespace App\Event\Slack;

use App\Entity\Slack\User;
use Symfony\Contracts\EventDispatcher\Event;

class NewUserEvent extends Event
{

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

}
