<?php

declare(strict_types=1);

namespace App\Handler\Request\User;

use App\Entity\Google\GoogleUser;
use App\Entity\Slack\SlackUser;

interface UserCreateOrUpdateInterface
{

    public function getEmail(): ?string;

    public function getName(): ?string;

    public function getPassword(): ?string;

    public function getSlackUser(): ?SlackUser;

    public function getGoogleUser(): ?GoogleUser;

}
