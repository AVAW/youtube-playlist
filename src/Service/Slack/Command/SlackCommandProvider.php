<?php

declare(strict_types=1);

namespace App\Service\Slack\Command;

use App\Entity\Slack\SlackCommand;
use App\Repository\Slack\SlackCommandRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class SlackCommandProvider
{

    protected SlackCommandRepository $repository;

    public function __construct(
        SlackCommandRepository $commandRepository
    ) {
        $this->repository = $commandRepository;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(SlackCommand $command)
    {
        $this->repository->save($command);
    }

}
