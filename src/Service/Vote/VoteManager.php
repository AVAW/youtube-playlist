<?php

declare(strict_types=1);

namespace App\Service\Vote;

class VoteManager
{

    private VoteProvider $voteProvider;

    public function __construct(
        VoteProvider $voteProvider
    ) {
        $this->voteProvider = $voteProvider;
    }

}
