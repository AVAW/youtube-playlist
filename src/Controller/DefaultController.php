<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Form\PlaylistType;
use Doctrine\ORM\EntityManagerInterface;
use Google_Client;
use Google_Service_YouTube;
use GuzzleHttp\Exception\ConnectException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function index(
        Request $request,
        EntityManagerInterface $em,
        TranslatorInterface $translator,
        Google_Client $client
    ): Response {
        $form = $this->createForm(PlaylistType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Playlist $playlist */
            $playlist = $form->getData();


            // Validate
            $plu = parse_url($playlist->getUrl());
            $s = null;
            parse_str($plu['query'], $s);
            $playlistId = $s['list'];

            $service = new Google_Service_YouTube($client);
            $part = [
                'contentDetails',
            ];
            $queryParams = [
                'maxResults' => 50,
                'playlistId' => $playlistId,
            ];

            try {
                $results = $service->playlistItems->listPlaylistItems($part, $queryParams);
            } catch (\Google_Service_Exception $e) {
                if ($e->getCode() === 404) {
                    dd($translator->trans('playlist.notFound'));
                }
            } catch (ConnectException $e) {
                dd('ConnectException');
            }

            $total = $results->getPageInfo()->getTotalResults();

            $videosIds = $this->getPageVideosIds($results);
            while (($results->getNextPageToken())) {
                $optParams = array_merge($queryParams, ['pageToken' => $results->getNextPageToken()]);
                $results = $service->playlistItems->listPlaylistItems($part, $optParams);
                $videosIds = array_merge($videosIds, $this->getPageVideosIds($results));
            }

//            $firstVideoId = array_pop($videosIds);
//            $video = $service->videos->listVideos($part, ['id' => $firstVideoId]);

            if (empty($videosIds)) {
                throw new \InvalidArgumentException('Empty playlist');
            }


            $playlist->setCreatedAt(new \DateTime());
            $playlist->setYoutubeId($playlistId);
            $playlist->setUuid(Uuid::v4());
            $em->persist($playlist);
            $em->flush();

            return $this->redirectToRoute('playlist', ['uuid' => $playlist->getUuid()]);
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    protected function getPageVideosIds($results): array
    {
        $videosIds = [];
        foreach ($results->getItems() as $item) {
            $videosIds [] = $item->getContentDetails()->videoId;
        }

        return $videosIds;
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
