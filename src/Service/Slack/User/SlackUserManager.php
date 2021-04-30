<?php

declare(strict_types=1);

namespace App\Service\Slack\User;

use App\Entity\Slack\SlackConversation;
use App\Entity\Slack\SlackTeam;
use App\Entity\Slack\SlackUser;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Uid\Uuid;

class SlackUserManager
{

    protected SlackUserProvider $provider;

    public function __construct(SlackUserProvider $provider)
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
        ?SlackTeam $team = null,
        ?SlackConversation $channel = null,
        ?string $realName = null,
        ?string $displayedName = null,
        ?string $title = null,
        ?string $phone = null,
        ?string $imageOriginalUrl = null,
        ?string $firstName = null,
        ?string $lastName = null
    ): SlackUser {
        $user = (new SlackUser())
            ->setProfileId($userId)
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

        if ($channel instanceof SlackConversation) {
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
        SlackUser $slackUser,
        ?SlackTeam $team,
        ?SlackConversation $conversation,
        ?string $email,
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
        $slackUser
            ->setTeam($team)
            ->setEmail($email)
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

        if ($conversation instanceof SlackConversation) {
            $slackUser->addConversation($conversation);
        }

        // Force to update because Doctrine knows when entity didnt change
        $slackUser->setUpdatedAt(new \DateTime());

        $this->provider->save($slackUser);
    }

}
