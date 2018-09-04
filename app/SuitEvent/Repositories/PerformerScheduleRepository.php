<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\PerformerSchedule;
use Suitcore\Repositories\SuitRepository;

class PerformerScheduleRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new PerformerSchedule;
    }
}
