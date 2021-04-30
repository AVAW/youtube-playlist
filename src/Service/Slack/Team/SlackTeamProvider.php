<?php

declare(strict_types=1);

namespace App\Service\Slack\Team;

use App\Entity\Slack\SlackTeam;
use App\Repository\Slack\SlackTeamRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class SlackTeamProvider
{

    protected SlackTeamRepository $repository;

    public function __construct(SlackTeamRepository $teamRepository)
    {
        $this->repository = $teamRepository;
    }

    /** @return SlackTeam[] */
    public function findAll(): iterable
    {
        return $this->repository->findAll();
    }

    public function findOneByTeamId(string $teamId): ?SlackTeam
    {
        return $this->repository->findOneBy(['teamId' => $teamId]);
    }

    public function findByTeamId(array $teamsIds): ?array
    {
        return $this->repository->findBy(['teamId' => $teamsIds]);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(SlackTeam $team)
    {
        $this->repository->save($team);
    }

    public function findByIdentifier(string $identifier): ?SlackTeam
    {
        try {
            return $this->repository->findOneBy(['identifier' => $identifier]);
        } catch (\Throwable $e) {
            return null;
        }
    }

}
