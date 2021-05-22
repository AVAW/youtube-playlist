<?php

declare(strict_types=1);

namespace App\Controller\Api\Slack;

use App\Entity\Slack\SlackAction;
use App\Form\Slack\Interactivity\SlackInteractivitiesType;
use App\Handler\Request\Slack\Action\ActionCollectionCreateRequestHandler;
use App\Handler\Request\Slack\Conversation\ConversationGetOrCreateRequestHandler;
use App\Handler\Request\Slack\Interactivity\InteractivityHandlerCollection;
use App\Handler\Request\Slack\Interactivity\InteractivityInterface;
use App\Handler\Request\Slack\Team\TeamGetOrCreateRequestHandler;
use App\Handler\Request\Slack\User\UserGetOrCreateRequestHandler;
use App\Model\Slack\Interactivity\InteractivityGetOrCreateRequest;
use App\Utils\Form\FormErrorHelper;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/api/slack/interactivity")
 */
class InteractivityController extends AbstractFOSRestController
{

    /**
     * @Route("/", methods={"POST"})
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function index(
        Request $request,
        TeamGetOrCreateRequestHandler $teamRequestHandler,
        ConversationGetOrCreateRequestHandler $channelRequestHandler,
        UserGetOrCreateRequestHandler $userRequestHandler,
        ActionCollectionCreateRequestHandler $actionsRequestHandler,
        InteractivityHandlerCollection $actionHandlers,
        TranslatorInterface $translator,
        LoggerInterface $logger
    ): Response {
        $payload = json_decode($request->request->get('payload'), true);
        if (empty($payload)) {
            throw new \InvalidArgumentException('Empty body, IP: ' . $request->getClientIp());
        }

        $actions = [];
        foreach ($payload['actions'] ?? [] as $action) {
            $actions [] = [
                'actionId' => $action['action_id'] ?? null,
                'value' => $action['value'] ?? null,
            ];
        }

        $command = new InteractivityGetOrCreateRequest();
        $form = $this->createForm(SlackInteractivitiesType::class, $command);
        $form->submit([
            'type' => $payload['type'] ?? null,
            'token' => $payload['token'] ?? null,
            'triggerId' => $payload['trigger_id'] ?? null,
            'enterprise' => $payload['enterprise'] ?? null,
            'isEnterpriseInstall' => $payload['is_enterprise_install'] ?? false,
            'responseUrl' => $payload['response_url'] ?? null,
            'team' => [
                'teamId' => $payload['team']['id'] ?? null,
                'teamDomain' => $payload['team']['domain'] ?? null,
            ],
            'conversation' => [
                'channelId' => $payload['channel']['id'] ?? null,
                'channelName' => $payload['channel']['name'] ?? null,
            ],
            'user' => [
                'userId' => $payload['user']['id'] ?? null,
                'userName' => $payload['user']['username'] ?? null,
            ],
            'actions' => $actions,
        ]);

        if ($form->isSubmitted() && $form->isValid()) {
            $team = $teamRequestHandler->handle($command->getTeam());
            $conversation = $channelRequestHandler->handle($command->getConversation());
            $user = $userRequestHandler->handle($command->getUser());
            $slackActions = $actionsRequestHandler->handle($team, $conversation, $user, $command);

            $handled = false;
            /** @var SlackAction $action */
            foreach ($slackActions as $action) {
                /** @var InteractivityInterface[] $actionHandlers */
                foreach ($actionHandlers as $handler) {
                    if ($handler->supports($action)) {
                        $handler->handle($action);
                        $handled = true;
                    }
                }
            }

            if ($handled) {
                return new Response('Success');
            }
        }

        if (!$form->isValid()) {
            $logger->error(json_encode(FormErrorHelper::errorsToArray($form)));
        }

        return new Response($translator->trans('interactivity.wrong'));
    }

}
