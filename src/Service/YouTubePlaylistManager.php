<?php

namespace App\Service;

use App\Entity\Playlist;
use Google_Client;
use Google_Service_YouTube;
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

    public function getPlaylistVideosIds(Playlist $playlist): array
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

        $videosIds = $this->getPageVideosIds($results);
        while ($results->getNextPageToken()) {
            $optParams = array_merge($queryParams, ['pageToken' => $results->getNextPageToken()]);
            $results = $this->service->playlistItems->listPlaylistItems($part, $optParams);
            $videosIds = array_merge($videosIds, $this->getPageVideosIds($results));
        }

//            $firstVideoId = array_pop($videosIds);
//            $video = $service->videos->listVideos($part, ['id' => $firstVideoId]);

        if (empty($videosIds)) {
            throw new \InvalidArgumentException('Empty playlist');
        }

        return $videosIds;
    }

    protected function getPageVideosIds($results): array
    {
        $videosIds = [];
        foreach ($results->getItems() as $item) {
            $videosIds [] = $item->getContentDetails()->videoId;
        }

        return $videosIds;
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
