<?php

declare(strict_types=1);

namespace App\Service\Slack\User;

use App\Entity\Slack\Conversation;
use App\Entity\Slack\Team;
use App\Entity\Slack\User;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Uid\Uuid;

class UserManager
{

    protected UserProvider $provider;

    public function __construct(UserProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(
        string $userId,
        string $name = null,
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
            ->setLastName($lastName)
            ->setIdentifier(Uuid::v4());

        if ($channel instanceof Conversation) {
            $user->addConversation($channel);
        }

        $this->provider->save($user);

        return $user;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
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
        ?string $lastName,
        ?bool $isAdmin,
        ?bool $isAppUser,
        ?bool $isBot,
        ?bool $isExternal,
        ?bool $isForgotten,
        ?bool $isInvitedUser,
        ?bool $isOwner,
        ?bool $isPrimaryOwner,
        ?bool $isRestricted,
        ?bool $isStranger,
        ?bool $isUltraRestricted
    ): void {
        $user
            ->setTeam($team)
            ->setRealName($realName)
            ->setDisplayedName($displayedName)
            ->setTitle($title)
            ->setPhone($phone)
            ->setImageOriginalUrl($imageOriginalUrl)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setIsAdmin($isAdmin)
            ->setIsAppUser($isAppUser)
            ->setIsBot($isBot)
            ->setIsExternal($isExternal)
            ->setIsForgotten($isForgotten)
            ->setIsInvitedUser($isInvitedUser)
            ->setIsOwner($isOwner)
            ->setIsPrimaryOwner($isPrimaryOwner)
            ->setIsRestricted($isRestricted)
            ->setIsStranger($isStranger)
            ->setIsUltraRestricted($isUltraRestricted);

        if ($channel instanceof Conversation) {
            $user->addConversation($channel);
        }

        // Force to update because Doctrine knows when entity didnt change
        $user->setUpdatedAt(new \DateTime());

        $this->provider->save($user);
    }

}
