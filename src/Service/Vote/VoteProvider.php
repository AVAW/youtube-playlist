<?php

declare(strict_types=1);

namespace App\Service\Vote;

use App\Repository\Vote\VoteRepository;

class VoteProvider
{

    private VoteRepository $voteRepository;

    public function __construct(
        VoteRepository $voteRepository
    ) {
        $this->voteRepository = $voteRepository;
    }

}
