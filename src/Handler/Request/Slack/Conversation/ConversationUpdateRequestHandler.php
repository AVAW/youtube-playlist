<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Conversation;

use App\Entity\Slack\Conversation;
use App\Service\Slack\Conversation\ConversationManager;
use App\Service\Slack\Conversation\ConversationProvider;
use App\Service\Slack\Team\TeamProvider;

class ConversationUpdateRequestHandler
{

    private ConversationManager $channelManager;
    private ConversationProvider $channelProvider;
    private TeamProvider $teamProvider;

    public function __construct(
        ConversationManager $channelManager,
        ConversationProvider $channelProvider,
        TeamProvider $teamProvider
    ) {
        $this->channelManager = $channelManager;
        $this->channelProvider = $channelProvider;
        $this->teamProvider = $teamProvider;
    }

    public function handle(Conversation $channel, ConversationUpdateInterface $command)
    {
        $teams = $this->teamProvider->findByTeamId($command->getTeams());

        $this->channelManager->update(
            $channel,
            $command->getName(),
            $teams,
            $command->getCreatorId(),
            $command->getIsArchived(),
            $command->getIsChannel(),
            $command->getIsExtShared(),
            $command->getIsFrozen(),
            $command->getIsGeneral(),
            $command->getIsGlobalShared(),
            $command->getIsGroup(),
            $command->getIsIm(),
            $command->getIsMoved(),
            $command->getIsMpim(),
            $command->getIsNonThreadable(),
            $command->getIsOpen(),
            $command->getIsOrgDefault(),
            $command->getIsPrivate(),
            $command->getIsShared(),
            $command->getPurpose(),
            $command->getTopic(),
        );
    }

}
