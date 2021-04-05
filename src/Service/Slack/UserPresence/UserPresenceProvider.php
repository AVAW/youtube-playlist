<?php

declare(strict_types=1);

namespace App\Service\Slack\UserPresence;

use App\Entity\Slack\UserPresence;
use App\Repository\Slack\UserPresenceRepository;

class UserPresenceProvider
{

    protected UserPresenceRepository $repository;

    public function __construct(UserPresenceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function save(UserPresence $userPresence)
    {
        $this->repository->save($userPresence);
    }

}
