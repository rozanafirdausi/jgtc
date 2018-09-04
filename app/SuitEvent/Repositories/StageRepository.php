<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\Stage;
use Suitcore\Repositories\SuitRepository;

class StageRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new Stage;
    }
}
