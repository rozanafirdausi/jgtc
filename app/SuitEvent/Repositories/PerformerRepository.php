<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\Performer;
use Suitcore\Repositories\SuitRepository;

class PerformerRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new Performer;
    }
}
