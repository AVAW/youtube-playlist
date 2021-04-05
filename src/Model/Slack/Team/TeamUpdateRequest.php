<?php

declare(strict_types=1);

namespace App\Model\Slack\Team;

use App\Handler\Request\Slack\Team\TeamUpdateInterface;
use JoliCode\Slack\Api\Model\ObjsTeam;

class TeamUpdateRequest implements TeamUpdateInterface
{

    private ?string $name;

    private ?string $emailDomain;

    private ?string $iconUrl;

    public static function createFromObjsTeam(ObjsTeam $slackTeam): self
    {
        return (new static)
            ->setName($slackTeam->getName())
            ->setEmailDomain($slackTeam->getEmailDomain())
            ->setIconUrl($slackTeam->getIcon()->getImage230());
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

    public function getEmailDomain(): ?string
    {
        return $this->emailDomain;
    }

    public function setEmailDomain(?string $emailDomain): self
    {
        $this->emailDomain = $emailDomain;

        return $this;
    }

    public function getIconUrl(): ?string
    {
        return $this->iconUrl;
    }

    public function setIconUrl(?string $iconUrl): self
    {
        $this->iconUrl = $iconUrl;

        return $this;
    }

}
