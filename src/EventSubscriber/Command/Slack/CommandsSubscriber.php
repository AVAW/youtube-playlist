<?php

declare(strict_types=1);

namespace App\EventSubscriber\Command\Slack;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Event\SlackCommand\CommandEvent;

class CommandsSubscriber implements EventSubscriberInterface
{

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onCommandEvent(CommandEvent $event)
    {
        $this->logger->error($event->getCommand());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CommandEvent::class => 'onCommandEvent',
        ];
    }

}
