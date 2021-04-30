<?php

declare(strict_types=1);

namespace App\Service\Slack\Command;

use App\Entity\Slack\SlackConversation;
use App\Entity\Slack\SlackCommand;
use App\Entity\Slack\SlackTeam;
use App\Entity\Slack\SlackUser;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Uid\Uuid;

class SlackCommandManager
{

    protected SlackCommandProvider $provider;

    public function __construct(SlackCommandProvider $commandProvider)
    {
        $this->provider = $commandProvider;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(
        SlackTeam $team,
        SlackConversation $conversation,
        SlackUser $user,
        string $name,
        ?string $text
    ): SlackCommand {
        $command = (new SlackCommand())
            ->setName($name)
            ->setTeam($team)
            ->setConversation($conversation)
            ->setUser($user)
            ->setText($text)
            ->setIdentifier(Uuid::v4());

        $this->provider->save($command);

        return $command;
    }

}
