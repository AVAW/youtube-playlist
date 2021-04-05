<?php

declare(strict_types=1);

namespace App\Service\Slack\Channel;

use App\Entity\Slack\Channel;
use App\Repository\Slack\ChannelRepository;

class ChannelProvider
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

    public function save(Channel $channel)
    {
        $this->channelRepository->save($channel);
    }

}
