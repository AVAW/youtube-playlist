<?php

declare(strict_types=1);

namespace App\Service\Slack\User;

use App\Entity\Slack\Channel;
use App\Entity\Slack\Team;
use App\Entity\Slack\User;

class UserManager
{

    protected UserProvider $provider;

    public function __construct(UserProvider $provider)
    {
        $this->provider = $provider;
    }

    public function create(
        string $userId,
        string $userName,
        ?Team $team = null,
        ?Channel $channel = null,
        ?string $realName = null,
        ?string $displayedName = null,
        ?string $title = null,
        ?string $phone = null,
        ?string $imageOriginalUrl = null,
        ?string $firstName = null,
        ?string $lastName = null
    ): User {
        $user = (new User())
            ->setUserId($userId)
            ->setName($userName)
            ->setTeam($team)
            ->addChannel($channel)
            ->setRealName($realName)
            ->setDisplayedName($displayedName)
            ->setTitle($title)
            ->setPhone($phone)
            ->setImageOriginalUrl($imageOriginalUrl)
            ->setFirstName($firstName)
            ->setLastName($lastName);

        $this->provider->save($user);

        return $user;
    }

    public function update(
        User $user,
        ?Team $team,
        ?string $realName,
        ?string $displayedName,
        ?string $title,
        ?string $phone,
        ?string $imageOriginalUrl,
        ?string $firstName,
        ?string $lastName
    ): User {
        $user
            ->setTeam($team)
            ->setRealName($realName)
            ->setDisplayedName($displayedName)
            ->setTitle($title)
            ->setPhone($phone)
            ->setImageOriginalUrl($imageOriginalUrl)
            ->setFirstName($firstName)
            ->setLastName($lastName);

        $this->provider->save($user);

        return $user;
    }

}
