<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\PerformerCandidate;
use Suitcore\Repositories\SuitRepository;

class PerformerCandidateRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new PerformerCandidate;
    }
}
