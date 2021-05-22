<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Interactivity;

use App\Entity\Slack\SlackAction;

interface InteractivityInterface
{

    public function supports(SlackAction $action): bool;

    public function handle(SlackAction $action);

}
