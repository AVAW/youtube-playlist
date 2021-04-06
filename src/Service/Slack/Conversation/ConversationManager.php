<?php

declare(strict_types=1);

namespace App\Service\Slack\Conversation;

use App\Entity\Slack\Conversation;
use App\Entity\Slack\Team;

class ConversationManager
{

    protected ConversationProvider $provider;

    public function __construct(ConversationProvider $provider)
    {
        $this->provider = $provider;
    }

    public function create(
        string $channelId,
        string $channelName
    ): Conversation {
        $channel = (new Conversation())
            ->setConversationId($channelId)
            ->setName($channelName);

        $this->provider->save($channel);

        return $channel;
    }

    public function update(
        Conversation $channel,
        string $name,
        ?array $teams = [],
        ?string $creatorId = null,
        ?bool $isArchived = null,
        ?bool $isChannel = null,
        ?bool $isExtShared = null,
        ?bool $isFrozen = null,
        ?bool $isGeneral = null,
        ?bool $isGlobalShared = null,
        ?bool $isGroup = null,
        ?bool $isIm = null,
        ?bool $isMoved = null,
        ?bool $isMpim = null,
        ?bool $isNonThreadable = null,
        ?bool $isOpen = null,
        ?bool $isOrgDefault = null,
        ?bool $isPrivate = null,
        ?bool $isShared = null,
        ?string $purpose = null,
        ?string $topic = null
    ): void {
        $channel
            ->setName($name)
            ->setCreatorId($creatorId)
            ->setIsArchived($isArchived)
            ->setIsChannel($isChannel)
            ->setIsExtShared($isExtShared)
            ->setIsFrozen($isFrozen)
            ->setIsGeneral($isGeneral)
            ->setIsGlobalShared($isGlobalShared)
            ->setIsGroup($isGroup)
            ->setIsIm($isIm)
            ->setIsMoved($isMoved)
            ->setIsMpim($isMpim)
            ->setIsNonThreadable($isNonThreadable)
            ->setIsOpen($isOpen)
            ->setIsOrgDefault($isOrgDefault)
            ->setIsPrivate($isPrivate)
            ->setIsShared($isShared)
            ->setPurpose($purpose)
            ->setTopic($topic);

        foreach ($teams as $team) {
            if ($team instanceof Team) {
                $channel->addTeam($team);
            }
        }

        $this->provider->save($channel);

    }

}
