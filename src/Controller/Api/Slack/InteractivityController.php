<?php

declare(strict_types=1);

namespace App\Controller\Api\Slack;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/slack/interactivity")
 */
class InteractivityController extends AbstractFOSRestController
{

    /**
     * @Route("/", methods={"POST"})
     */
    public function index(
        Request $request,
        LoggerInterface $logger
    ): View {
//  "type" => "block_actions"
//  "user" => array:4 [▶]
//  "api_app_id" => "A01T11DHP9U"
//  "token" => "x"
//  "container" => array:4 [▶]
//  "trigger_id" => "1970889166705.204538098757.0a7232ed4679eb16faee0ad956910e51"
//  "team" => array:2 [▼
//    "id" => "T60FU2WN9"
//    "domain" => "arris-agency"
//  ]
//  "enterprise" => null
//  "is_enterprise_install" => false
//  "channel" => array:2 [▼
//    "id" => "C01ST1PKATH"
//    "name" => "privategroup"
//  ]
//  "message" => array:7 [▼
//    "bot_id" => "B01TLD55A9F"
//    "type" => "message"
//    "text" => "This content can't be displayed."
//    "user" => "U01TDVA4P9A"
//    "ts" => "1618333366.001700"
//    "team" => "T60FU2WN9"
//    "blocks" => array:4 [▶]
//  ]
//  "state" => array:1 [▼
//    "values" => []
//  ]
//  "response_url" => "https://hooks.slack.com/actions/T60FU2WN9/1982077187136/7DidfkakK9bfg3CSw9fn6fOD"
//  "actions" => array:1 [▼
//    0 => array:6 [▼
//      "action_id" => "click-open-playlist-button"
//      "block_id" => "FASKv"
//      "text" => array:3 [▶]
//      "value" => "10707821-d710-4f07-998b-2d83bec8c81f"
//      "type" => "button"
//      "action_ts" => "1618333369.386695"
//    ]
//  ]
        $a = json_decode($request->request->get('payload'), true);

        return $this->view();
    }

}
