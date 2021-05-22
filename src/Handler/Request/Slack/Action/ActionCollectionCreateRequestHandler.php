<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Action;

use App\Entity\Slack\SlackAction;
use App\Entity\Slack\SlackConversation;
use App\Entity\Slack\SlackTeam;
use App\Entity\Slack\SlackUser;
use App\Service\Slack\Action\SlackActionManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ActionCollectionCreateRequestHandler
{

    private SlackActionManager $slackActionManager;

    public function __construct(
        SlackActionManager $slackActionManager
    ) {
        $this->slackActionManager = $slackActionManager;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle(
        SlackTeam $team,
        SlackConversation $conversation,
        SlackUser $user,
        ActionCollectionCreateInterface $command
    ): array {
        $slackActions = [];

        /** @var ActionCreateInterface $action */
        foreach ($command->getActions() as $action) {
            $slackActions [] = $this->slackActionManager->create(
                $team,
                $conversation,
                $user,
                $command->getType(),
                $command->getResponseUrl(),
                $command->getTriggerId(),
                $command->getEnterprise(),
                $command->isEnterpriseInstall(),
                $action->getActionId(),
                $action->getValue(),
            );
        }

        return $slackActions;
    }

}
