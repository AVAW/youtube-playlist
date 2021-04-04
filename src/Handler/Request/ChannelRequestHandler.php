<?php

declare(strict_types=1);

namespace App\Handler\Request;

use App\Entity\Slack\Channel;
use App\Model\Slack\Command\CommandChannelInterface;
use App\Service\Slack\ChannelManager;

class ChannelRequestHandler
{

    private ChannelManager $channelManager;

    public function __construct(ChannelManager $channelManager)
    {
        $this->channelManager = $channelManager;
    }

    public function handle(CommandChannelInterface $command): Channel
    {
        $channel = $this->channelManager->findByChannelId($command->getChannelId());
        if (!$channel instanceof Channel) {
            $channel = $this->channelManager->create($command->getChannelId(), $command->getChannelName());
        }

        return $channel;
    }

}
