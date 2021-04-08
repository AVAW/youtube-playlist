<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Playlist;
use App\Form\ContactType;
use App\Form\YouTubePlaylistType;
use App\Model\Slack\Conversation\ConversationUpdateRequest;
use App\Repository\ContactRepository;
use App\Repository\PlaylistRepository;
use App\Service\Slack\Conversation\ConversationProvider;
use App\Utils\YouTubePlaylist;
use JoliCode\Slack\Api\Client;
use Psr\Log\LoggerInterface;
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
        YouTubePlaylist $youTubePlaylist,
        ConversationProvider $conversationProvider,
        Client $client,
        LoggerInterface $infoLogger
    ): Response {
        $conversation = $conversationProvider->findByConversationId('D01TN9RGJMP');
        $slackUser = $client->usersInfo(['user' => 'U01DDGBHA5U'])->getUser();
        dump($slackUser);
        $slackUser = $client->usersInfo(['user' => 'U01TDVA4P9A'])->getUser();
        dd($slackUser);
        $slackChannel = $client->conversationsInfo(['channel' => 'D01TN9RGJMP'])->getChannel();
        dd($slackChannel);
        $command = ConversationUpdateRequest::createFromObjConversation($slackChannel);
        $this->conversationUpdateRequestHandler->handle($conversation, $command);
        $form = $this->createForm(YouTubePlaylistType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Playlist $playlist */
            $playlist = $form->getData();

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
    public function contact(
        Request $request,
        ContactRepository $contactRepository
    ): Response {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Contact $contact */
            $contact = $form->getData();

            $contact->setCreatedAt(new \DateTime());
            $contact->setClientIp($request->getClientIp());

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
