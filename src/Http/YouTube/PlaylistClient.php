<?php

declare(strict_types=1);

namespace App\Http\YouTube;

use App\Dto\Playlist\PlaylistDto;
use App\Dto\Playlist\VideoDto;
use App\Exception\ForbiddenException;
use App\Exception\NotExistsException;
use Google_Client;
use Google_Service_YouTube;
use Google_Service_YouTube_PlaylistItem;
use Google_Service_YouTube_PlaylistItemListResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class PlaylistClient
{

    const API_URL = 'https://www.googleapis.com/youtube/v3/playlists';

    protected Google_Client $client;
    protected Google_Service_YouTube $service;
    protected LoggerInterface $logger;
    protected TranslatorInterface $translator;
    protected HttpClientInterface $httpClient;

    public function __construct(
        HttpClientInterface $httpClient,
        LoggerInterface $logger,
        TranslatorInterface $translator,
        Google_Client $client
    ) {
        $this->client = $client;
        $this->httpClient = $httpClient;
        $this->logger = $logger;
        $this->service = new Google_Service_YouTube($client);
        $this->translator = $translator;
    }

    /**
     * @param int $limit 0 => limitless
     * @return VideoDto[]
     */
    public function getPlaylistVideos(string $youTubeId, int $limit = 0): array
    {
        $part = [
            'id',
            'snippet',
            'contentDetails',
        ];
        $queryParams = [
            'maxResults' => 50,
            'playlistId' => $youTubeId,
        ];

        try {
            $results = $this->service->playlistItems->listPlaylistItems($part, $queryParams);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
            return [];
        }

        $videos = $this->getPageVideos($results);
        while ($results->getNextPageToken()) {
            $optParams = array_merge($queryParams, ['pageToken' => $results->getNextPageToken()]);
            $results = $this->service->playlistItems->listPlaylistItems($part, $optParams);
            $videos = array_merge($videos, $this->getPageVideos($results));

            $amount = count($videos);
            if ($limit !== 0 && $amount >= $limit) {
                break;
            }
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
        $snippet = $item->getSnippet();

        return new VideoDto(
            $item->getContentDetails()->getVideoId(),
            $snippet->getTitle(),
            \DateTime::createFromFormat(DATE_ISO8601, $snippet->getPublishedAt()),
            $snippet->getVideoOwnerChannelId(),
            $snippet->getVideoOwnerChannelTitle(),
            $snippet->getThumbnails()->getDefault()->getUrl(),
            $snippet->getThumbnails()->getMedium()->getUrl(),
            $snippet->getThumbnails()->getHigh()->getUrl()
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
        $res = new PlaylistDto();

        if (empty($youTubeId)) {
            return $res;
        }

        $queryParameters = [
            'part' => implode(',', ['snippet']),
            'id' => $youTubeId,
            'fields' => 'items(snippet)',
            'key' => $this->client->getConfig('developer_key'),
        ];

        $query = http_build_query($queryParameters);
        $url = static::API_URL . '?' . $query;

        try {
            $output = $this->httpClient->request('GET', $url)->getContent();
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
            return $res;
        }

        $result = (array) json_decode($output);
        if (empty($result['items'])) {
            return $res;
        }

        $item = array_pop($result['items']);
        if (!property_exists($item, 'snippet')) {
            return $res;
        }

        $snippet = $item->snippet;

        if (property_exists($snippet, 'title')) {
            $res->setTitle($snippet->title);
        }
        if (property_exists($snippet, 'description')) {
            $res->setDescription($snippet->description);
        }
        if (property_exists($snippet, 'publishedAt')) {
            $res->setPublishedAt(\DateTime::createFromFormat(DATE_ISO8601, $snippet->publishedAt));
        }
        if (property_exists($snippet, 'channelTitle')) {
            $res->setChannelTitle($snippet->channelTitle);
        }

        return $res;
    }

    /**
     * @throws ForbiddenException
     * @throws NotExistsException
     */
    public function isValidUrl(string $url): bool
    {
        $playlistId = $this->getPlaylistIdFromUrl($url);
        if (empty($playlistId)) {
            return false;
        }

        $part = [
            'contentDetails',
        ];
        $queryParams = [
            'maxResults' => 1,
            'playlistId' => $playlistId,
        ];

        try {
            $this->service->playlistItems->listPlaylistItems($part, $queryParams);
        } catch (\Google\Service\Exception $e) {
            if ($e->getCode() === Response::HTTP_FORBIDDEN) {
                throw new ForbiddenException($this->translator->trans('playlist.error.forbidden'));
            } elseif ($e->getCode() === Response::HTTP_NOT_FOUND) {
                throw new NotExistsException($this->translator->trans('playlist.notFound'));
            }
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }

        return true;
    }

    public function getPlaylistIdFromUrl(string $url): ?string
    {
        $parsedUrl = parse_url($url);
        if (empty($parsedUrl['query'])) {
            return null;
        }

        $query = null;
        parse_str($parsedUrl['query'], $query);
        if (empty($query['list'])) {
            return null;
        }

        return $query['list'];
    }

}
