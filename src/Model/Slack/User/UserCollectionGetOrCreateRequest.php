<?php

declare(strict_types=1);

namespace App\Model\Slack\User;

use App\Handler\Request\Slack\User\UserCollectionGetOrCreateInterface;

class UserCollectionGetOrCreateRequest implements UserCollectionGetOrCreateInterface
{

    private array $usersIds;

    public static function createFromArray(array $collection): self
    {
        return (new static)
            ->setUsersIds($collection);
    }

    public function getUsersIds(): array
    {
        return $this->usersIds;
    }

    public function setUsersIds(array $usersIds): self
    {
        $this->usersIds = $usersIds;

        return $this;
    }

}
