<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\PerformerCandidateVote;
use Suitcore\Repositories\SuitRepository;

class PerformerCandidateVoteRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new PerformerCandidateVote;
    }
}
