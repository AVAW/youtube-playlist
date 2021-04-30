<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\User;

use App\Entity\Slack\SlackTeam;

interface UserUpdateInterface
{

    public function getTeamId(): ?string;

    public function getEmail(): ?string;

    public function getDisplayedName(): ?string;

    public function getTitle(): ?string;

    public function getRealName(): ?string;

    public function getPhone(): ?string;

    public function getImageOriginalUrl(): ?string;

    public function getFirstName(): ?string;

    public function getLastName(): ?string;

    public function getIsAdmin(): ?bool;

    public function getIsAppUser(): ?bool;

    public function getIsBot(): ?bool;

    public function getIsExternal(): ?bool;

    public function getIsForgotten(): ?bool;

    public function getIsInvitedUser(): ?bool;

    public function getIsOwner(): ?bool;

    public function getIsPrimaryOwner(): ?bool;

    public function getIsRestricted(): ?bool;

    public function getIsStranger(): ?bool;

    public function getIsUltraRestricted(): ?bool;

}
