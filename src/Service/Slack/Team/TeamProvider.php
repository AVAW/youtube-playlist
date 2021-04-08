<?php

declare(strict_types=1);

namespace App\Service\Slack\Team;

use App\Entity\Slack\Team;
use App\Repository\Slack\TeamRepository;

class TeamProvider
{

    protected TeamRepository $repository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->repository = $teamRepository;
    }

    /** @return Team[] */
    public function findAll(): iterable
    {
        return $this->repository->findAll();
    }

    public function findOneByTeamId(string $teamId): ?Team
    {
        return $this->repository->findOneBy(['teamId' => $teamId]);
    }

    public function findByTeamId(array $teamsIds): ?array
    {
        return $this->repository->findBy(['teamId' => $teamsIds]);
    }

    public function save(Team $team)
    {
        $this->repository->save($team);
    }

}
