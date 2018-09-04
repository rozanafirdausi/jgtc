<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\Attraction;
use Suitcore\Repositories\SuitRepository;

class AttractionRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new Attraction;
    }
}
