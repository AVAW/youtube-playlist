<?php

declare(strict_types=1);

namespace App\Service\Slack\Conversation;

use App\Entity\Slack\SlackConversation;
use App\Entity\Slack\SlackTeam;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Uid\Uuid;

class SlackConversationManager
{

    protected SlackConversationProvider $provider;

    public function __construct(SlackConversationProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(
        string $channelId,
        string $channelName
    ): SlackConversation {
        $channel = (new SlackConversation())
            ->setConversationId($channelId)
            ->setName($channelName)
            ->setIdentifier(Uuid::v4());

        $this->provider->save($channel);

        return $channel;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(
        SlackConversation $channel,
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
        ?string $topic = null,
        ?string $locale = null
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
            ->setTopic($topic)
            ->setLocale($locale);

        foreach ($teams as $team) {
            if ($team instanceof SlackTeam) {
                $channel->addTeam($team);
            }
        }

        // Force to update because Doctrine knows when entity didnt change
        $channel->setUpdatedAt(new \DateTime());

        $this->provider->save($channel);
    }

}
