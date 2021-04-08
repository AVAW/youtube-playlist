<?php

declare(strict_types=1);

namespace App\Model\Slack\User;

use App\Handler\Request\Slack\User\UserUpdateInterface;
use JoliCode\Slack\Api\Model\ObjsUser;

class UserUpdateRequest implements UserUpdateInterface
{

    private ?string $teamId;
    private ?string $displayedName;
    private ?string $title;
    private ?string $realName;
    private ?string $phone;
    private ?string $imageOriginalUrl;
    private ?string $firstName;
    private ?string $lastName;
    private ?bool $isAdmin;
    private ?bool $isAppUser;
    private ?bool $isBot;
    private ?bool $isExternal;
    private ?bool $isForgotten;
    private ?bool $isInvitedUser;
    private ?bool $isOwner;
    private ?bool $isPrimaryOwner;
    private ?bool $isRestricted;
    private ?bool $isStranger;
    private ?bool $isUltraRestricted;

    public static function createFromObjsUser(ObjsUser $slackUser): self
    {
        $slackUserProfile = $slackUser->getProfile();

        return (new static)
            ->setTeamId($slackUser->getTeamId())
            ->setDisplayedName($slackUserProfile->getDisplayNameNormalized())
            ->setTitle($slackUserProfile->getTitle())
            ->setRealName($slackUserProfile->getRealNameNormalized())
            ->setPhone($slackUserProfile->getPhone())
            ->setImageOriginalUrl($slackUserProfile->getImageOriginal())
            ->setFirstName($slackUserProfile->getFirstName())
            ->setLastName($slackUserProfile->getLastName())
            ->setIsAdmin($slackUser->getIsAdmin())
            ->setIsAppUser($slackUser->getIsAppUser())
            ->setIsBot($slackUser->getIsBot())
            ->setIsExternal($slackUser->getIsExternal())
            ->setIsForgotten($slackUser->getIsForgotten())
            ->setIsInvitedUser($slackUser->getIsInvitedUser())
            ->setIsOwner($slackUser->getIsOwner())
            ->setIsPrimaryOwner($slackUser->getIsPrimaryOwner())
            ->setIsRestricted($slackUser->getIsRestricted())
            ->setIsStranger($slackUser->getIsStranger())
            ->setIsUltraRestricted($slackUser->getIsUltraRestricted());
    }

    public function getTeamId(): ?string
    {
        return $this->teamId;
    }

    public function setTeamId(?string $teamId): self
    {
        $this->teamId = $teamId;

        return $this;
    }

    public function getDisplayedName(): ?string
    {
        return $this->displayedName;
    }

    public function setDisplayedName(?string $displayedName): self
    {
        $this->displayedName = $displayedName;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getRealName(): ?string
    {
        return $this->realName;
    }

    public function setRealName(?string $realName): self
    {
        $this->realName = $realName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getImageOriginalUrl(): ?string
    {
        return $this->imageOriginalUrl;
    }

    public function setImageOriginalUrl(?string $imageOriginalUrl): self
    {
        $this->imageOriginalUrl = $imageOriginalUrl;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(?bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function getIsAppUser(): ?bool
    {
        return $this->isAppUser;
    }

    public function setIsAppUser(?bool $isAppUser): self
    {
        $this->isAppUser = $isAppUser;

        return $this;
    }

    public function getIsBot(): ?bool
    {
        return $this->isBot;
    }

    public function setIsBot(?bool $isBot): self
    {
        $this->isBot = $isBot;

        return $this;
    }

    public function getIsExternal(): ?bool
    {
        return $this->isExternal;
    }

    public function setIsExternal(?bool $isExternal): self
    {
        $this->isExternal = $isExternal;

        return $this;
    }

    public function getIsForgotten(): ?bool
    {
        return $this->isForgotten;
    }

    public function setIsForgotten(?bool $isForgotten): self
    {
        $this->isForgotten = $isForgotten;

        return $this;
    }

    public function getIsInvitedUser(): ?bool
    {
        return $this->isInvitedUser;
    }

    public function setIsInvitedUser(?bool $isInvitedUser): self
    {
        $this->isInvitedUser = $isInvitedUser;

        return $this;
    }

    public function getIsOwner(): ?bool
    {
        return $this->isOwner;
    }

    public function setIsOwner(?bool $isOwner): self
    {
        $this->isOwner = $isOwner;

        return $this;
    }

    public function getIsPrimaryOwner(): ?bool
    {
        return $this->isPrimaryOwner;
    }

    public function setIsPrimaryOwner(?bool $isPrimaryOwner): self
    {
        $this->isPrimaryOwner = $isPrimaryOwner;

        return $this;
    }

    public function getIsRestricted(): ?bool
    {
        return $this->isRestricted;
    }

    public function setIsRestricted(?bool $isRestricted): self
    {
        $this->isRestricted = $isRestricted;

        return $this;
    }

    public function getIsStranger(): ?bool
    {
        return $this->isStranger;
    }

    public function setIsStranger(?bool $isStranger): self
    {
        $this->isStranger = $isStranger;

        return $this;
    }

    public function getIsUltraRestricted(): ?bool
    {
        return $this->isUltraRestricted;
    }

    public function setIsUltraRestricted(?bool $isUltraRestricted): self
    {
        $this->isUltraRestricted = $isUltraRestricted;

        return $this;
    }

}
