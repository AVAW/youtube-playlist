<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\Google\GoogleUser;
use App\Entity\Slack\SlackUser;
use App\Entity\User\User;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Uid\UuidV4;

class UserManager
{

    private UserProvider $provider;

    public function __construct(
        UserProvider $userProvider
    ) {
        $this->provider = $userProvider;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function create(
        $login = null,
        ?string $email = null
    ): User {
        $user = (new User)
            ->setLogin($login)
            ->setEmail($email)
            ->setIdentifier(new UuidV4());

        $this->provider->save($user);

        return $user;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function update(
        User $user,
        ?string $login = null,
        ?string $email = null,
        ?SlackUser $slackUser = null,
        ?GoogleUser $googleUser = null
    ): void {
        $user
            ->setLogin($login)
            ->setEmail($email);

        if ($slackUser instanceof SlackUser) {
            $user->setSlackUser($slackUser);
        }
        if ($googleUser instanceof GoogleUser) {
            $user->setGoogleUser($googleUser);
        }

        $this->provider->save($user);
    }

}
