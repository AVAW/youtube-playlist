<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\User;

use App\Entity\Slack\SlackUser;
use App\Service\Slack\Team\SlackTeamProvider;
use App\Service\Slack\User\SlackUserManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class UserUpdateRequestHandler
{

    private SlackUserManager $userManager;
    private SlackTeamProvider $teamProvider;

    public function __construct(
        SlackUserManager $userManager,
        SlackTeamProvider $teamProvider
    ) {
        $this->userManager = $userManager;
        $this->teamProvider = $teamProvider;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle(SlackUser $slackUser, UserUpdateInterface $command)
    {
        $team = $this->teamProvider->findOneByTeamId($command->getTeamId());

        $this->userManager->update(
            $slackUser,
            $team,
            null,
            $command->getEmail(),
            $command->getRealName(),
            $command->getDisplayedName(),
            $command->getTitle(),
            $command->getPhone(),
            $command->getImageOriginalUrl(),
            $command->getFirstName(),
            $command->getLastName(),
            $command->getIsAdmin(),
            $command->getIsAppUser(),
            $command->getIsBot(),
            $command->getIsExternal(),
            $command->getIsForgotten(),
            $command->getIsInvitedUser(),
            $command->getIsOwner(),
            $command->getIsPrimaryOwner(),
            $command->getIsRestricted(),
            $command->getIsStranger(),
            $command->getIsUltraRestricted()
        );
    }

}
