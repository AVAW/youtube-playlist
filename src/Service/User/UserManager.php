<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User\User;
use Symfony\Component\Uid\UuidV4;

class UserManager
{

    private UserProvider $provider;

    public function __construct(
        UserProvider $userProvider
    ) {
        $this->provider = $userProvider;
    }

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

}
