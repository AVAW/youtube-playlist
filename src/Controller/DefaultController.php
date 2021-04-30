<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Form\YouTubePlaylistType;
use App\Handler\Request\Playlist\PlaylistCreateRequestHandler;
use App\Model\Playlist\PlaylistCreateRequest;
use App\Repository\ContactRepository;
use App\Repository\User\UserRepository;
use App\Service\User\UserProvider;
use DateTime;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
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
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function index(
        Request $request,
        PlaylistCreateRequestHandler $playlistCreateRequestHandler



, UserRepository $userRepository
    ): Response {
        // PLAYGROUND



//$user = $userRepository->findOneByEmailInProfiles('a.wojcik@arris.pl');
//dd($user);








        $command = new PlaylistCreateRequest();
        $form = $this->createForm(YouTubePlaylistType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var PlaylistCreateRequest $command */
            $command = $form->getData();
            $playlist = $playlistCreateRequestHandler->handle($command);

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
     * @throws ORMException
     * @throws OptimisticLockException
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
                ->setCreatedAt(new DateTime())
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
