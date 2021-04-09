<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Playlist\PlaylistDto;
use App\Dto\Playlist\VideoDto;
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
            // todo
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

    protected function getVideoData(Google_Service_YouTube_PlaylistItem $item): VideoDto
    {
        return new VideoDto(
            $item->getContentDetails()->videoId,
            $item->getSnippet()->title,
            \DateTime::createFromFormat(DATE_ISO8601, $item->getSnippet()->getPublishedAt()),
        );
    }

    public function getVideosAmountInPlaylist(string $youTubeId): ?int
    {
        $part = [
            'contentDetails',
        ];
        $queryParams = [
            'maxResults' => 1,
            'playlistId' => $youTubeId,
        ];

        try {
            $results = $this->service->playlistItems->listPlaylistItems($part, $queryParams);
            return $results->getPageInfo()->getTotalResults();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * IDK why but I can't get it in youtube lib
     */
    public function getPlaylistDetails(string $youTubeId): ?PlaylistDto
    {
        $apiUrl = 'https://www.googleapis.com/youtube/v3/playlists';
        $queryParameters = [
            'part' => implode(',', ['snippet']),
            'id' => $youTubeId,
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
            return null;
        }

        $item = array_pop($result['items']);
        if (!property_exists($item, 'snippet')) {
            return null;
        }

        $snippet = $item->snippet;

        if (!property_exists($snippet, 'title')
            || !property_exists($snippet, 'description')
            || !property_exists($snippet, 'publishedAt')
            || !property_exists($snippet, 'channelTitle')
        ) {
            return null;
        }

        return new PlaylistDto(
            $snippet->title,
            $snippet->description,
            \DateTime::createFromFormat(DATE_ISO8601, $snippet->publishedAt),
            $snippet->channelTitle
        );
    }

}
