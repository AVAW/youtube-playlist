<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\User;

use App\Entity\Slack\User;
use App\Service\Slack\Conversation\ConversationProvider;
use App\Service\Slack\Team\TeamProvider;
use App\Service\Slack\User\UserManager;
use App\Service\Slack\User\UserProvider;

class UserUpdateOrCreateRequestHandler
{

    private ConversationProvider $channelProvider;
    private TeamProvider $teamProvider;
    private UserManager $userManager;
    private UserProvider $userProvider;

    public function __construct(
        ConversationProvider $channelProvider,
        TeamProvider $teamProvider,
        UserManager $userManager,
        UserProvider $userProvider
    ) {
        $this->channelProvider = $channelProvider;
        $this->teamProvider = $teamProvider;
        $this->userManager = $userManager;
        $this->userProvider = $userProvider;
    }

    public function handle(UserUpdateOrCreateInterface $command): User
    {
        $team = $this->teamProvider->findOneByTeamId($command->getTeamId());
        $channel = $this->channelProvider->findByConversationId($command->getChannelId());

        $user = $this->userProvider->findByUserId($command->getUserId());
        if ($user instanceof User) {
            $this->userManager->update(
                $user,
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

            return $user;
        }


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
