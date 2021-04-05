<?php

namespace App\Handler\Request\Slack\User;

use App\Entity\Slack\User;
use App\Service\Slack\Channel\ChannelProvider;
use App\Service\Slack\Team\TeamProvider;
use App\Service\Slack\User\UserManager;
use App\Service\Slack\User\UserProvider;

class UserCreateRequestHandler
{

    private ChannelProvider $channelProvider;
    private TeamProvider $teamProvider;
    private UserManager $userManager;
    private UserProvider $userProvider;

    public function __construct(
        ChannelProvider $channelProvider,
        TeamProvider $teamProvider,
        UserManager $userManager,
        UserProvider $userProvider
    ) {
        $this->channelProvider = $channelProvider;
        $this->teamProvider = $teamProvider;
        $this->userManager = $userManager;
        $this->userProvider = $userProvider;
    }

    public function handle(UserCreateInterface $command): User
    {
        $team = $this->teamProvider->findByTeamId($command->getTeamId());
        $channel = $this->channelProvider->findByChannelId($command->getChannelId());

        return $this->userManager->create(
            $command->getUserId(),
            $command->getUserName(),
            $team,
            $channel,
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
