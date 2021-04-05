<?php

declare(strict_types=1);

namespace App\Service\Slack\Channel;

use App\Entity\Slack\Channel;
use App\Entity\Slack\Team;

class ChannelManager
{

    protected ChannelProvider $provider;

    public function __construct(ChannelProvider $provider)
    {
        $this->provider = $provider;
    }

    public function create(
        string $channelId,
        string $channelName
    ): Channel {
        $channel = (new Channel())
            ->setChannelId($channelId)
            ->setName($channelName);

        $this->provider->save($channel);

        return $channel;
    }

    public function update(
        Channel $channel,
        ?Team $team,
        $name = null
    ): Channel {
        $channel
            ->setTeam($team)
            ->setName($name);

        $this->provider->save($channel);

        return $channel;
    }

}
