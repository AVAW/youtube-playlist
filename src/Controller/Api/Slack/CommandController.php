<?php

declare(strict_types=1);

namespace App\Controller\Api\Slack;

use App\Event\Slack\NewConversationEvent;
use App\Event\Slack\NewCommandEvent;
use App\Event\Slack\NewTeamEvent;
use App\Event\Slack\NewUserEvent;
use App\Form\Slack\Command\CommandType;
use App\Handler\Request\Slack\Conversation\ConversationGetOrCreateRequestHandler;
use App\Handler\Request\Slack\Command\CommandCreateRequestHandler;
use App\Handler\Request\Slack\Team\TeamGetOrCreateRequestHandler;
use App\Handler\Request\Slack\User\UserGetOrCreateRequestHandler;
use App\Model\Slack\GetOrCreateRequest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * @Route("/api/slack")
 */
class CommandController extends AbstractFOSRestController
{

    /**
     * @Route("/command", methods={"POST"})
     */
    public function index(
        Request $request,
        TeamGetOrCreateRequestHandler $teamRequestHandler,
        ConversationGetOrCreateRequestHandler $channelRequestHandler,
        UserGetOrCreateRequestHandler $userRequestHandler,
        CommandCreateRequestHandler $commandRequestHandler,
        EventDispatcherInterface $dispatcher
    ): object {
        // todo: add https://api.slack.com/authentication/verifying-requests-from-slack#about
        // hash('sha256', $request->request->all() . $request->headers->get('x-slack-signature'));

        $command = new GetOrCreateRequest();
        $form = $this->createForm(CommandType::class, $command);
        $form->submit([
            'token' => $request->request->get('token'),
            'teamId' => $request->request->get('team_id'),
            'teamDomain' => $request->request->get('team_domain'),
            'channelId' => $request->request->get('channel_id'),
            'channelName' => $request->request->get('channel_name'),
            'userId' => $request->request->get('user_id'),
            'userName' => $request->request->get('user_name'),
            'command' => $request->request->get('command'),
            'text' => $request->request->get('text'),
        ]);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var GetOrCreateRequest $command */
            $command = $form->getData();

            $team = $teamRequestHandler->handle($command);
            $conversation = $channelRequestHandler->handle($command);
            $user = $userRequestHandler->handle($command);

            $command = $commandRequestHandler->handle($team, $conversation, $user, $command);


            return $this->render('slack_command/commands.html.twig');
        }

        return $this->handleView(View::create(['form' => $form], Response::HTTP_UNPROCESSABLE_ENTITY));
    }

}
