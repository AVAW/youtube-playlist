<?php

declare(strict_types=1);

namespace App\Service\Vote;

class VotePlaylistVideoCalculator
{

    private ?int $amountOfVotesRequired = null;
    private ?int $votes = null;

    public function init(int $votes, int $users): VotePlaylistVideoCalculator
    {
        $this->votes = $votes;
        $this->amountOfVotesRequired = $this->countVotesRequired($users);

        return $this;
    }

    public function getVotes(): ?int
    {
        return $this->votes;
    }

    public function getRequiredVotes(): ?int
    {
        return $this->amountOfVotesRequired;
    }

    public function isFulfilled(): bool
    {
        return $this->getVotes() >= $this->getRequiredVotes();
    }

    protected function countVotesRequired(int $users): int
    {
        $votesMatrix = [
            1 => 1,
            2 => 2,
            3 => 2,
        ];

        if ($users >= 1 && $users <= 3) {
            return $votesMatrix[$users];
        }

        return (int) floor($users / 2);
    }

}
