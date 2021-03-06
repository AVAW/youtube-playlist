<?php

declare(strict_types=1);

namespace App\Controller\Api\Slack;

use App\Form\Slack\SlashCommands\SlackSlashCommandsType;
use App\Handler\Request\Slack\Conversation\ConversationGetOrCreateRequestHandler;
use App\Handler\Request\Slack\Command\CommandCreateRequestHandler;
use App\Handler\Request\Slack\SlashCommands\CommandHandlerCollection;
use App\Handler\Request\Slack\SlashCommands\CommandInterface;
use App\Handler\Request\Slack\Team\TeamGetOrCreateRequestHandler;
use App\Handler\Request\Slack\User\UserGetOrCreateRequestHandler;
use App\Model\Slack\SlashCommands\GetOrCreateRequest;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/api/slack/slash-command")
 */
class SlashCommandsController extends AbstractFOSRestController
{

    /**
     * @Route("/", methods={"POST"})
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function index(
        Request $request,
        TeamGetOrCreateRequestHandler $teamRequestHandler,
        ConversationGetOrCreateRequestHandler $channelRequestHandler,
        UserGetOrCreateRequestHandler $userRequestHandler,
        CommandCreateRequestHandler $commandRequestHandler,
        CommandHandlerCollection $commandHandlers,
        TranslatorInterface $translator
    ): Response {
        // todo: add https://api.slack.com/authentication/verifying-requests-from-slack#about
        // hash('sha256', $request->request->all() . $request->headers->get('x-slack-signature'));

        $command = new GetOrCreateRequest();
        $form = $this->createForm(SlackSlashCommandsType::class, $command);
        $form->submit([
            'token' => $request->request->get('token'),
            'team' => [
                'teamId' => $request->request->get('team_id'),
                'teamDomain' => $request->request->get('team_domain'),
            ],
            'conversation' => [
                'channelId' => $request->request->get('channel_id'),
                'channelName' => $request->request->get('channel_name'),
            ],
            'user' => [
                'userId' => $request->request->get('user_id'),
                'userName' => $request->request->get('user_name'),
            ],
            'command' => $request->request->get('command'),
            'text' => $request->request->get('text'),
        ]);

        if ($form->isSubmitted() && $form->isValid()) {
            $team = $teamRequestHandler->handle($command->getTeam());
            $conversation = $channelRequestHandler->handle($command->getConversation());
            $user = $userRequestHandler->handle($command->getUser());
            $command = $commandRequestHandler->handle($team, $conversation, $user, $command);

            /** @var CommandInterface[] $commandHandlers */
            foreach ($commandHandlers as $handler) {
                if ($handler->supports($command)) {
                    $res = $handler->handle($command);

                    return new Response($res);
                }
            }
        }

        return new Response($translator->trans('slash-command.wrong'));
    }

}
