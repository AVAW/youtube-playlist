<?php

declare(strict_types=1);

namespace App\Utils;

use Google_Client;
use Google_Service_YouTube;

class YouTubePlaylistHelper
{

    protected Google_Client $client;
    protected Google_Service_YouTube $service;

    public function __construct(Google_Client $client)
    {
        $this->client = $client;
        $this->service = new Google_Service_YouTube($client);
    }

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
        } catch (\Exception $e) {
            return false;
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
