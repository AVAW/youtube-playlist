<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Conversation;

use App\Entity\Slack\SlackConversation;
use App\Service\Slack\Conversation\SlackConversationManager;
use App\Service\Slack\Conversation\SlackConversationProvider;
use App\Service\Slack\Team\SlackTeamProvider;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ConversationUpdateRequestHandler
{

    private SlackConversationManager $channelManager;
    private SlackConversationProvider $channelProvider;
    private SlackTeamProvider $teamProvider;

    public function __construct(
        SlackConversationManager $channelManager,
        SlackConversationProvider $channelProvider,
        SlackTeamProvider $teamProvider
    ) {
        $this->channelManager = $channelManager;
        $this->channelProvider = $channelProvider;
        $this->teamProvider = $teamProvider;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle(SlackConversation $channel, ConversationUpdateInterface $command)
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
            $command->getLocale(),
        );
    }

}
