<?php

namespace App\Handler\Request\Slack\User;

interface UserCreateInterface extends UserGetOrCreateInterface
{

    public function getTeamId(): ?string;

    public function getChannelId(): ?string;

    public function getDisplayedName(): ?string;

    public function getTitle(): ?string;

    public function getRealName(): ?string;

    public function getPhone(): ?string;

    public function getImageOriginalUrl(): ?string;

    public function getFirstName(): ?string;

    public function getLastName(): ?string;


}
