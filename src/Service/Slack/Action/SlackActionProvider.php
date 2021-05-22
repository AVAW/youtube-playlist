<?php

declare(strict_types=1);

namespace App\Service\Slack\Action;

use App\Entity\Slack\SlackAction;
use App\Repository\Slack\SlackActionRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class SlackActionProvider
{

    private SlackActionRepository $repository;

    public function __construct(
        SlackActionRepository $slackActionRepository
    ) {
        $this->repository = $slackActionRepository;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save(SlackAction $action)
    {
        $this->repository->save($action);
    }

}
