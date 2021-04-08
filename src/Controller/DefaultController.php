<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Playlist;
use App\Form\ContactType;
use App\Form\YouTubePlaylistType;
use App\Repository\ContactRepository;
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
        $form = $this->createForm(YouTubePlaylistType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Playlist $playlist */
            $playlist = $form->getData();

            $playlistId = $youTubePlaylist->getPlaylistIdFromUrl($playlist->getUrl());
            $playlist
                ->setYoutubeId($playlistId)
                ->setIdentifier(Uuid::v4());

            $playlistRepository->save($playlist);

            return $this->redirectToRoute('playlist', ['identifier' => $playlist->getIdentifier()]);
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
    public function contact(
        Request $request,
        ContactRepository $contactRepository
    ): Response {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Contact $contact */
            $contact = $form->getData();

            $contact
                ->setCreatedAt(new \DateTime())
                ->setClientIp($request->getClientIp())
                ->setIdentifier(Uuid::v4());

            $contactRepository->save($contact);

            return $this->redirectToRoute('contact');
        }

        $contacts = $contactRepository->findAll();

        return $this->render('default/contact.html.twig', [
            'form' => $form->createView(),
            'contacts' => $contacts,
        ]);
    }

}
