<?php

namespace App\Service;

use App\Entity\Playlist;
use Google_Client;
use Google_Service_YouTube;
use Google_Service_YouTube_PlaylistItem;
use Google_Service_YouTube_PlaylistItemListResponse;
use GuzzleHttp\Exception\ConnectException;
use Symfony\Contracts\Translation\TranslatorInterface;

class YouTubePlaylistManager
{

    protected Google_Client $client;
    protected Google_Service_YouTube $service;
    protected TranslatorInterface $translator;

    public function __construct(
        TranslatorInterface $translator,
        Google_Client $client
    ) {
        $this->client = $client;
        $this->service = new Google_Service_YouTube($client);
        $this->translator = $translator;
    }

    public function getPlaylistVideos(Playlist $playlist): array
    {
        $part = [
            'id',
            'snippet',
            'contentDetails',
        ];
        $queryParams = [
            'maxResults' => 50,
            'playlistId' => $playlist->getYoutubeId(),
        ];

        $results = null;
        try {
            $results = $this->service->playlistItems->listPlaylistItems($part, $queryParams);
        } catch (\Google_Service_Exception $e) {
            dd($e);
            if ($e->getCode() === 404) {
                dd($this->translator->trans('playlist.notFound'));
            }
        } catch (ConnectException $e) {
            dd('ConnectException');
        }

        $videos = $this->getPageVideos($results);
        while ($results->getNextPageToken()) {
            $optParams = array_merge($queryParams, ['pageToken' => $results->getNextPageToken()]);
            $results = $this->service->playlistItems->listPlaylistItems($part, $optParams);
            $videos = array_merge($videos, $this->getPageVideos($results));
        }

        return $videos;
    }

    protected function getPageVideos(Google_Service_YouTube_PlaylistItemListResponse $results): array
    {
        $videos = [];
        foreach ($results->getItems() as $item) {
            $videos [] = $this->getVideoData($item);
        }

        return $videos;
    }

    protected function getVideoData(Google_Service_YouTube_PlaylistItem $item): array
    {
        return [
            'id' => $item->getContentDetails()->videoId,
            'title' => $item->getSnippet()->title,
            'publishedAt' => \DateTime::createFromFormat(DATE_ISO8601, $item->getSnippet()->getPublishedAt()),
        ];
    }

    public function getVideosAmountInPlaylist(Playlist $playlist): void
    {
        $part = [
            'contentDetails',
        ];
        $queryParams = [
            'maxResults' => 1,
            'playlistId' => $playlist->getYoutubeId(),
        ];

        try {
            $results = $this->service->playlistItems->listPlaylistItems($part, $queryParams);
            $amount = $results->getPageInfo()->getTotalResults();
            $playlist->setVideosAmount($amount);
        } catch (\Exception $e) {
            return;
        }
    }

    /**
     * IDK why but I can't get it in youtube lib
     */
    public function getPlaylistDetails(Playlist $playlist): void
    {
        $apiUrl = 'https://www.googleapis.com/youtube/v3/playlists';
        $queryParameters = [
            'part' => implode(',', ['snippet']),
            'id' => $playlist->getYoutubeId(),
            'fields' => 'items(snippet)',
            'key' => $this->client->getConfig('developer_key'),
        ];

        $query = http_build_query($queryParameters);
        $url = $apiUrl . '?' . $query;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $result = (array) json_decode($output);
        if (empty($result['items'])) {
            return;
        }

        $item = array_pop($result['items']);
        if (!property_exists($item, 'snippet')) {
            return;
        }

        $snippet = $item->snippet;

        if (!property_exists($snippet, 'title')
            || !property_exists($snippet, 'description')
            || !property_exists($snippet, 'publishedAt')
            || !property_exists($snippet, 'channelTitle')
        ) {
            return;
        }

        $playlist->setTitle($snippet->title);
        $playlist->setDescription($snippet->description);
        $playlist->setPublishedAt(\DateTime::createFromFormat(DATE_ISO8601, $snippet->publishedAt));
        $playlist->setChannelTitle($snippet->channelTitle);
    }


}
