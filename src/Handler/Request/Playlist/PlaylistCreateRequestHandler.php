<?php

declare(strict_types=1);

namespace App\Handler\Request\Playlist;

use App\Entity\Playlist\Playlist;
use App\Entity\Slack\SlackCommand;
use App\Http\YouTube\PlaylistClient;
use App\Service\Playlist\PlaylistManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class PlaylistCreateRequestHandler
{

    private PlaylistManager $playlistManager;
    private PlaylistClient $youTubePlaylistClient;

    public function __construct(
        PlaylistManager $playlistManager,
        PlaylistClient $youTubePlaylistClient
    ) {
        $this->playlistManager = $playlistManager;
        $this->youTubePlaylistClient = $youTubePlaylistClient;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handle(PlaylistCreateInterface $createCommand, SlackCommand $command = null): Playlist
    {
        $youTubeId = $this->youTubePlaylistClient->getPlaylistIdFromUrl($createCommand->getUrl());
        $playlistDto = $this->youTubePlaylistClient->getPlaylistDetails($youTubeId);
        $amount = $this->youTubePlaylistClient->getVideosAmountInPlaylist($youTubeId);

        return $this->playlistManager->create(
            $createCommand->getUrl(),
            $youTubeId,
            $playlistDto->title,
            $playlistDto->description,
            $playlistDto->publishedAt,
            $playlistDto->channelTitle,
            $amount
        );
    }

}
