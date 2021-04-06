<?php

declare(strict_types=1);

namespace App\Service\Slack\Command;

use App\Entity\Slack\Command;
use App\Repository\Slack\CommandRepository;

class CommandProvider
{

    protected CommandRepository $repository;

    public function __construct(
        CommandRepository $commandRepository
    ) {
        $this->repository = $commandRepository;
    }

    public function save(Command $command)
    {
        $this->repository->save($command);
    }

}
