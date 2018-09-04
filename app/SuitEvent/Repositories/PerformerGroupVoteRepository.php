<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\PerformerGroupVote;
use Suitcore\Repositories\SuitRepository;

class PerformerGroupVoteRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new PerformerGroupVote;
    }
}
