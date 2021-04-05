<?php

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
            ->setLastName($slackUserProfile->getLastName());
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

}
