<?php

declare(strict_types=1);

namespace App\Service\Slack\User;

use App\Entity\Slack\Conversation;
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
        string $name,
        ?Team $team = null,
        ?Conversation $channel = null,
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
            ->setName($name)
            ->setTeam($team)
            ->setRealName($realName)
            ->setDisplayedName($displayedName)
            ->setTitle($title)
            ->setPhone($phone)
            ->setImageOriginalUrl($imageOriginalUrl)
            ->setFirstName($firstName)
            ->setLastName($lastName);

        if ($channel instanceof Conversation) {
            $user->addConversation($channel);
        }

        $this->provider->save($user);

        return $user;
    }

    public function update(
        User $user,
        ?Team $team,
        ?Conversation $channel,
        ?string $realName,
        ?string $displayedName,
        ?string $title,
        ?string $phone,
        ?string $imageOriginalUrl,
        ?string $firstName,
        ?string $lastName
    ): void {
        $user
            ->setTeam($team)
            ->setRealName($realName)
            ->setDisplayedName($displayedName)
            ->setTitle($title)
            ->setPhone($phone)
            ->setImageOriginalUrl($imageOriginalUrl)
            ->setFirstName($firstName)
            ->setLastName($lastName);

        if ($channel instanceof Conversation) {
            $user->addConversation($channel);
        }

        // Force to update because Doctrine knows when entity didnt change
        $user->setUpdatedAt(new \DateTime());

        $this->provider->save($user);
    }

}
