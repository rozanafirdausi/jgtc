<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\PerformerReview;
use Suitcore\Repositories\SuitRepository;

class PerformerReviewRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new PerformerReview;
    }
}
