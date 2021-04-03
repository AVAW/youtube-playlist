<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Form\PlaylistType;
use App\Repository\PlaylistRepository;
use App\Utils\YouTubePlaylist;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="home")
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function index(
        Request $request,
        PlaylistRepository $playlistRepository,
        YouTubePlaylist $youTubePlaylist
    ): Response {
        $form = $this->createForm(PlaylistType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Playlist $playlist */
            $playlist = $form->getData();

            $playlist->setCreatedAt(new \DateTime());
            $playlistId = $youTubePlaylist->getPlaylistIdFromUrl($playlist->getUrl());
            $playlist->setYoutubeId($playlistId);
            $playlist->setUuid(Uuid::v4());

            $playlistRepository->save($playlist);

            return $this->redirectToRoute('playlist', ['uuid' => $playlist->getUuid()]);
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('default/about.html.twig', [
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('default/contact.html.twig', [
            'form' => null,
        ]);
    }

}
