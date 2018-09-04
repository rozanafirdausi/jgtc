<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\PerformerSpecification;
use Suitcore\Repositories\SuitRepository;

class PerformerSpecificationRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new PerformerSpecification;
    }
}
