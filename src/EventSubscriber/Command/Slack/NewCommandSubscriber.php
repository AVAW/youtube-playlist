<?php

declare(strict_types=1);

namespace App\EventSubscriber\Command\Slack;

use JoliCode\Slack\Api\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Event\Slack\NewCommandEvent;

class NewCommandSubscriber implements EventSubscriberInterface
{

    private Client $client;
    private LoggerInterface $logger;

    public function __construct(
        Client $client,
        LoggerInterface $logger
    ) {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function onNewCommandEvent(NewCommandEvent $event)
    {
        $command = $event->getCommand();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NewCommandEvent::class => 'onNewCommandEvent',
        ];
    }

}
