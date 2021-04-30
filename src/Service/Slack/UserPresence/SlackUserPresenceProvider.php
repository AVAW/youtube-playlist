<?php

declare(strict_types=1);

namespace App\Service\Slack\UserPresence;

use App\Entity\Slack\SlackUserPresence;
use App\Repository\Slack\SlackUserPresenceRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class SlackUserPresenceProvider
{

    protected SlackUserPresenceRepository $repository;

    public function __construct(SlackUserPresenceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(SlackUserPresence $userPresence)
    {
        $this->repository->save($userPresence);
    }

}
