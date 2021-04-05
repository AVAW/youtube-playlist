<?php

declare(strict_types=1);

namespace App\Handler\Request\Slack\Channel;

use App\Entity\Slack\Channel;
use App\Service\Slack\Channel\ChannelManager;
use App\Service\Slack\Channel\ChannelProvider;

class ChannelGetOrCreateRequestHandler
{

    private ChannelManager $channelManager;
    private ChannelProvider $channelProvider;

    public function __construct(
        ChannelManager $channelManager,
        ChannelProvider $channelProvider
    ) {
        $this->channelManager = $channelManager;
        $this->channelProvider = $channelProvider;
    }

    public function handle(ChannelGetOrCreateInterface $command): Channel
    {
        $channel = $this->channelProvider->findByChannelId($command->getChannelId());
        if (!$channel instanceof Channel) {
            $channel = $this->channelManager->create($command->getChannelId(), $command->getChannelName());
        }

        return $channel;
    }

}
