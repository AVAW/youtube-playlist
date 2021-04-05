<?php

declare(strict_types=1);

namespace App\Event\Slack;

use App\Entity\Slack\Team;
use Symfony\Contracts\EventDispatcher\Event;

class TeamEvent extends Event
{

    private Team $team;

    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }

}
