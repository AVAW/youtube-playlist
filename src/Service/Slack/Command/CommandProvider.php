<?php

declare(strict_types=1);

namespace App\Service\Slack\Command;

use App\Entity\Slack\Command;
use App\Repository\Slack\CommandRepository;

class CommandProvider
{

    protected CommandRepository $commandRepository;

    public function __construct(
        CommandRepository $commandRepository
    ) {
        $this->commandRepository = $commandRepository;
    }

    public function save(Command $command)
    {
        $this->commandRepository->save($command);
    }

}
