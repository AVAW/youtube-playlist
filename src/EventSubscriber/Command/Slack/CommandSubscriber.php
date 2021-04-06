<?php

declare(strict_types=1);

namespace App\EventSubscriber\Command\Slack;

use JoliCode\Slack\Api\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Event\Slack\CommandEvent;

class CommandSubscriber implements EventSubscriberInterface
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

    public function onCommandEvent(CommandEvent $event)
    {
        $command = $event->getCommand();

        $team = $command->getTeam();
        $channel = $command->getConversation();
        $user = $command->getUser();
        $user->addConversation($channel);



        // Send messgae to chat
//        $response = $this->client->chatPostMessage([
//            'channel' => '#mniejsze-okna-playlist',
////            'username' => 'example bot',
//            'text' => 'Hello world',
//        ]);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CommandEvent::class => 'onCommandEvent',
        ];
    }

}
