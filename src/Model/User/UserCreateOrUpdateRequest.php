<?php

declare(strict_types=1);

namespace App\Model\User;

use App\Entity\Google\GoogleUser;
use App\Entity\Slack\SlackUser;
use App\Handler\Request\User\UserCreateOrUpdateInterface;

class UserCreateOrUpdateRequest implements UserCreateOrUpdateInterface
{

    private ?string $email;
    private ?string $name;
    private ?string $password;
    private ?SlackUser $slackUser;
    private ?GoogleUser $googleUser;

    public static function create(
        ?string $email,
        ?string $name,
        ?string $password = null,
        ?SlackUser $slackUser = null,
        ?GoogleUser $googleUser = null
    ): self {
        return (new static)
            ->setEmail($email)
            ->setName($name)
            ->setPassword($password)
            ->setSlackUser($slackUser)
            ->setGoogleUser($googleUser);
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSlackUser(): ?SlackUser
    {
        return $this->slackUser;
    }

    public function setSlackUser(?SlackUser $slackUser): self
    {
        $this->slackUser = $slackUser;

        return $this;
    }

    public function getGoogleUser(): ?GoogleUser
    {
        return $this->googleUser;
    }

    public function setGoogleUser(?GoogleUser $googleUser): self
    {
        $this->googleUser = $googleUser;

        return $this;
    }

}
