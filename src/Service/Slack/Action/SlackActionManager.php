<?php

declare(strict_types=1);

namespace App\Service\Slack\Action;

use App\Entity\Slack\SlackAction;
use App\Entity\Slack\SlackConversation;
use App\Entity\Slack\SlackTeam;
use App\Entity\Slack\SlackUser;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Uid\UuidV4;

class SlackActionManager
{

    private SlackActionProvider $provider;

    public function __construct(
        SlackActionProvider $provider
    ) {
        $this->provider = $provider;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function create(
        SlackTeam $team,
        SlackConversation $conversation,
        SlackUser $user,
        string $type,
        string $responseUrl,
        string $triggerId,
        ?string $enterprise,
        bool $isEnterpriseInstall,
        string $getActionId,
        string $getValue
    ): SlackAction {
        $action = (new SlackAction())
            ->setTeam($team)
            ->setConversation($conversation)
            ->setUser($user)
            ->setType($type)
            ->setResponseUrl($responseUrl)
            ->setTriggerId($triggerId)
            ->setEnterprise($enterprise)
            ->setIsEnterpriseInstall($isEnterpriseInstall)
            ->setActionId($getActionId)
            ->setValue($getValue)
            ->setIdentifier(new UuidV4());

        $this->provider->save($action);

        return $action;
    }

}
