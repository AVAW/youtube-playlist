<?php

declare(strict_types=1);

namespace App\Service\Slack\Team;

use App\Entity\Slack\SlackTeam;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Uid\Uuid;

class SlackTeamManager
{

    protected SlackTeamProvider $provider;

    public function __construct(SlackTeamProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(
        string $teamId,
        string $teamDomain
    ): SlackTeam {
        $team = (new SlackTeam())
            ->setTeamId($teamId)
            ->setDomain($teamDomain)
            ->setIdentifier(Uuid::v4());

        $this->provider->save($team);

        return $team;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(
        SlackTeam $team,
        ?string $name,
        ?string $emailDomain,
        ?string $iconUrl
    ): void {
        $team
            ->setName($name)
            ->setEmailDomain($emailDomain)
            ->setIconUrl($iconUrl);

        // Force to update because Doctrine knows when entity didnt change
        $team->setUpdatedAt(new \DateTime());

        $this->provider->save($team);
    }

}
