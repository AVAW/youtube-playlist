<?php

declare(strict_types=1);

namespace App\Service\Google\User;

use App\Entity\Google\GoogleUser;
use App\Entity\User\User;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Uid\UuidV4;

class GoogleUserManager
{

    private GoogleUserProvider $provider;

    public function __construct(
        GoogleUserProvider $googleUserProvider
    ) {
        $this->provider = $googleUserProvider;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(
        ?User $user,
        $googleId,
        string $name = null,
        ?string $email = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $locale = null,
        ?string $avatar = null
    ): GoogleUser {
        $googleProfile = (new GoogleUser())
            ->setUser($user)
            ->setProfileId($googleId)
            ->setDisplayedName($name)
            ->setEmail($email)
            ->setName($firstName)
            ->setSurname($lastName)
            ->setLocale($locale)
            ->setPicture($avatar)
            ->setIdentifier(new UuidV4());

        $this->provider->save($googleProfile);

        return $googleProfile;
    }

}
