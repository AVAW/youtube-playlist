<?php

declare(strict_types=1);

namespace App\Model\Slack\Conversation;

use App\Handler\Request\Slack\Conversation\ConversationUpdateInterface;
use JoliCode\Slack\Api\Model\ObjsConversation;

class ConversationUpdateRequest implements ConversationUpdateInterface
{

    private ?string $name;
    private array $teams;
    private ?string $creatorId;
    private ?bool $isArchived;
    private ?bool $isChannel;
    private ?bool $isExtShared;
    private ?bool $isFrozen;
    private ?bool $isGeneral;
    private ?bool $isGlobalShared;
    private ?bool $isGroup;
    private ?bool $isIm;
    private ?bool $isMoved;
    private ?bool $isMpim;
    private ?bool $isNonThreadable;
    private ?bool $isOpen;
    private ?bool $isOrgDefault;
    private ?bool $isPrivate;
    private ?bool $isShared;
    private ?string $purpose;
    private ?string $topic;
    private ?string $locale;

    public static function createFromObjConversation(?ObjsConversation $conversation): self
    {
        return (new static)
            ->setName($conversation->getNameNormalized())
            ->setTeams($conversation->getSharedTeamIds())
            ->setCreatorId($conversation->getCreator())
            ->setIsArchived($conversation->getIsArchived())
            ->setIsChannel($conversation->getIsChannel())
            ->setIsExtShared($conversation->getIsExtShared())
            ->setIsFrozen($conversation->getIsFrozen())
            ->setIsGeneral($conversation->getIsGeneral())
            ->setIsGlobalShared($conversation->getIsGlobalShared())
            ->setIsGroup($conversation->getIsGroup())
            ->setIsIm($conversation->getIsIm())
            ->setIsMoved($conversation->getIsMoved())
            ->setIsMpim($conversation->getIsMpim())
            ->setIsNonThreadable($conversation->getIsNonThreadable())
            ->setIsOpen($conversation->getIsOpen())
            ->setIsOrgDefault($conversation->getIsOrgDefault())
            ->setIsPrivate($conversation->getIsPrivate())
            ->setIsShared($conversation->getIsShared())
            ->setPurpose($conversation->getPurpose()->getValue())
            ->setTopic($conversation->getTopic()->getValue())
            ->setLocale('en-US'/*$conversation->getLocale()*/);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTeams(): array
    {
        return $this->teams;
    }

    public function setTeams(array $teams): self
    {
        $this->teams = $teams;

        return $this;
    }

    public function getCreatorId(): ?string
    {
        return $this->creatorId;
    }

    public function setCreatorId(?string $creatorId): self
    {
        $this->creatorId = $creatorId;

        return $this;
    }

    public function getIsArchived(): ?bool
    {
        return $this->isArchived;
    }

    public function setIsArchived(?bool $isArchived): self
    {
        $this->isArchived = $isArchived;

        return $this;
    }

    public function getIsChannel(): ?bool
    {
        return $this->isChannel;
    }

    public function setIsChannel(?bool $isChannel): self
    {
        $this->isChannel = $isChannel;

        return $this;
    }

    public function getIsExtShared(): ?bool
    {
        return $this->isExtShared;
    }

    public function setIsExtShared(?bool $isExtShared): self
    {
        $this->isExtShared = $isExtShared;

        return $this;
    }

    public function getIsFrozen(): ?bool
    {
        return $this->isFrozen;
    }

    public function setIsFrozen(?bool $isFrozen): self
    {
        $this->isFrozen = $isFrozen;

        return $this;
    }

    public function getIsGeneral(): ?bool
    {
        return $this->isGeneral;
    }

    public function setIsGeneral(?bool $isGeneral): self
    {
        $this->isGeneral = $isGeneral;

        return $this;
    }

    public function getIsGlobalShared(): ?bool
    {
        return $this->isGlobalShared;
    }

    public function setIsGlobalShared(?bool $isGlobalShared): self
    {
        $this->isGlobalShared = $isGlobalShared;

        return $this;
    }

    public function getIsGroup(): ?bool
    {
        return $this->isGroup;
    }

    public function setIsGroup(?bool $isGroup): self
    {
        $this->isGroup = $isGroup;

        return $this;
    }

    public function getIsIm(): ?bool
    {
        return $this->isIm;
    }

    public function setIsIm(?bool $isIm): self
    {
        $this->isIm = $isIm;
        return $this;
    }

    public function getIsMoved(): ?bool
    {
        return $this->isMoved;
    }

    public function setIsMoved(?bool $isMoved): self
    {
        $this->isMoved = $isMoved;

        return $this;
    }

    public function getIsMpim(): ?bool
    {
        return $this->isMpim;
    }

    public function setIsMpim(?bool $isMpim): self
    {
        $this->isMpim = $isMpim;

        return $this;
    }

    public function getIsNonThreadable(): ?bool
    {
        return $this->isNonThreadable;
    }

    public function setIsNonThreadable(?bool $isNonThreadable): self
    {
        $this->isNonThreadable = $isNonThreadable;

        return $this;
    }

    public function getIsOpen(): ?bool
    {
        return $this->isOpen;
    }

    public function setIsOpen(?bool $isOpen): self
    {
        $this->isOpen = $isOpen;

        return $this;
    }

    public function getIsOrgDefault(): ?bool
    {
        return $this->isOrgDefault;
    }

    public function setIsOrgDefault(?bool $isOrgDefault): self
    {
        $this->isOrgDefault = $isOrgDefault;

        return $this;
    }

    public function getIsPrivate(): ?bool
    {
        return $this->isPrivate;
    }

    public function setIsPrivate(?bool $isPrivate): self
    {
        $this->isPrivate = $isPrivate;

        return $this;
    }

    public function getIsShared(): ?bool
    {
        return $this->isShared;
    }

    public function setIsShared(?bool $isShared): self
    {
        $this->isShared = $isShared;

        return $this;
    }

    public function getPurpose(): ?string
    {
        return $this->purpose;
    }

    public function setPurpose(?string $purpose): self
    {
        $this->purpose = $purpose;

        return $this;
    }

    public function getTopic(): ?string
    {
        return $this->topic;
    }

    public function setTopic(?string $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

}
