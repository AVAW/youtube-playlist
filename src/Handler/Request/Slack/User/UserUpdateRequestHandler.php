<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\User;

use App\Entity\Slack\User;
use App\Service\Slack\Team\TeamProvider;
use App\Service\Slack\User\UserManager;

class UserUpdateRequestHandler
{

    private UserManager $userManager;
    private TeamProvider $teamProvider;

    public function __construct(
        UserManager $userManager,
        TeamProvider $teamProvider
    ) {
        $this->userManager = $userManager;
        $this->teamProvider = $teamProvider;
    }

    public function handle(User $user, UserUpdateInterface $command)
    {
        $team = $this->teamProvider->findOneByTeamId($command->getTeamId());

        $this->userManager->update(
            $user,
            $team,
            null,
            $command->getRealName(),
            $command->getDisplayedName(),
            $command->getTitle(),
            $command->getPhone(),
            $command->getImageOriginalUrl(),
            $command->getFirstName(),
            $command->getLastName(),
        );
    }

}
