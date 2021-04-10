<?php

declare(strict_types=1);

namespace App\Controller\Api\Playlist;

use App\Entity\Playlist\Playlist;
use App\Form\PlaylistType;
use App\Handler\Request\Playlist\PlaylistFindHandler;
use App\Model\Playlist\PlaylistFindRequest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/playlist")
 */
class PlaylistController extends AbstractFOSRestController
{

    /**
     * @Route("/", methods={"POST"})
     * @FOSRest\View(serializerGroups={"playlist"})
     */
    public function index(
        Request $request,
        PlaylistFindHandler $playlistHandler
    ): View {
        $command = new PlaylistFindRequest();
        $form = $this->createForm(PlaylistType::class, $command);
        $form->submit($request->toArray());

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var PlaylistFindRequest $command */
            $command = $form->getData();

            $playlist = $playlistHandler->handle($command);
            if (!$playlist instanceof Playlist) {
                throw new \InvalidArgumentException('Can not find playlist');
            }

            return $this->view([
                'playlist' => $playlist,
            ]);
        }

        return $this->view(['form' => $form]);
    }

}
