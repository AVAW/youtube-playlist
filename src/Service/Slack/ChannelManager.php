<?php

declare(strict_types=1);

namespace App\Service\Slack;

use App\Entity\Slack\Channel;
use App\Repository\Slack\ChannelRepository;

class ChannelManager
{

    protected ChannelRepository $channelRepository;

    public function __construct(ChannelRepository $channelRepository)
    {
        $this->channelRepository = $channelRepository;
    }

    public function findByChannelId(string $channelId): ?Channel
    {
        return $this->channelRepository->findOneBy(['channelId' => $channelId]);
    }

    public function create(
        string $channelId,
        string $channelName
    ): Channel {
        $channel = (new Channel())
            ->setChannelId($channelId)
            ->setName($channelName);

        $this->channelRepository->save($channel);

        return $channel;
    }

}
