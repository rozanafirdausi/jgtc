<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\PerformerGroup;
use Suitcore\Repositories\SuitRepository;

class PerformerGroupRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new PerformerGroup;
    }
}
