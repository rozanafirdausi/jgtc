<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\EventReview;
use Suitcore\Repositories\SuitRepository;

class EventReviewRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new EventReview;
    }
}
