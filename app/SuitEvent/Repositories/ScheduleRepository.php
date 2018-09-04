<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\Schedule;
use Suitcore\Repositories\SuitRepository;

class ScheduleRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new Schedule;
    }
}
