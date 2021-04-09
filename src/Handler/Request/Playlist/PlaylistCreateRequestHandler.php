<?php

declare(strict_types=1);

namespace App\Handler\Request\Playlist;

use App\Entity\Playlist;
use App\Service\Playlist\PlaylistManager;
use App\Service\YouTubePlaylistManager;
use App\Utils\YouTubePlaylistHelper;

class PlaylistCreateRequestHandler
{

    private PlaylistManager $playlistManager;
    private YouTubePlaylistHelper $youTubePlaylistHelper;
    private YouTubePlaylistManager $youTubePlaylistManager;

    public function __construct(
        PlaylistManager $playlistManager,
        YouTubePlaylistHelper $youTubePlaylistHelper,
        YouTubePlaylistManager $youTubePlaylistManager
    ) {
        $this->playlistManager = $playlistManager;
        $this->youTubePlaylistHelper = $youTubePlaylistHelper;
        $this->youTubePlaylistManager = $youTubePlaylistManager;
    }

    public function handle(PlaylistCreateInterface $command): Playlist
    {
        $youTubeId = $this->youTubePlaylistHelper->getPlaylistIdFromUrl($command->getUrl());
        $playlistDto = $this->youTubePlaylistManager->getPlaylistDetails($youTubeId);
        $amount = $this->youTubePlaylistManager->getVideosAmountInPlaylist($youTubeId);

        return $this->playlistManager->create(
            $command->getUrl(),
            $youTubeId,
            $playlistDto->title,
            $playlistDto->description,
            $playlistDto->publishedAt,
            $playlistDto->channelTitle,
            $amount,
        );
    }

}
