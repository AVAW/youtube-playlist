<?php

declare(strict_types=1);

namespace App\Service\Slack\Command;

use App\Entity\Slack\Command;
use App\Repository\Slack\CommandRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class CommandProvider
{

    protected CommandRepository $repository;

    public function __construct(
        CommandRepository $commandRepository
    ) {
        $this->repository = $commandRepository;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Command $command)
    {
        $this->repository->save($command);
    }

}
