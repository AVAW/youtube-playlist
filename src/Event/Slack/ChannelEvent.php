<?php

declare(strict_types=1);

namespace App\Event\Slack;

use App\Entity\Slack\Channel;
use Symfony\Contracts\EventDispatcher\Event;

class ChannelEvent extends Event
{

    private Channel $channel;

    public function __construct(Channel $channel)
    {
        $this->channel = $channel;
    }

    public function getChannel(): Channel
    {
        return $this->channel;
    }

}
