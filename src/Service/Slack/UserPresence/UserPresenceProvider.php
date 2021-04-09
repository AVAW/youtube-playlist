<?php

declare(strict_types=1);

namespace App\Service\Slack\UserPresence;

use App\Entity\Slack\UserPresence;
use App\Repository\Slack\UserPresenceRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class UserPresenceProvider
{

    protected UserPresenceRepository $repository;

    public function __construct(UserPresenceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(UserPresence $userPresence)
    {
        $this->repository->save($userPresence);
    }

}
