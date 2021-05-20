<?php

declare(strict_types=1);

namespace App\Handler\Request\User;

use App\Entity\User\User;
use App\Service\User\UserManager;
use App\Service\User\UserProvider;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class UserCreateOrUpdateRequestHandler
{

    private UserManager $userManager;
    private UserProvider $userProvider;

    public function __construct(
        UserManager $userManager,
        UserProvider $userProvider
    ) {
        $this->userManager = $userManager;
        $this->userProvider = $userProvider;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function handle(UserCreateOrUpdateInterface $command)
    {
        $user = $this->userProvider->findByEmail($command->getEmail());
        if (!$user instanceof User) {
            $user = $this->userManager->create(
                $command->getName(),
                $command->getEmail()
            );
        }

        $this->userManager->update(
            $user,
            $command->getName(),
            $command->getEmail(),
            $command->getSlackUser(),
            $command->getGoogleUser(),
        );

        return $user;
    }

}
