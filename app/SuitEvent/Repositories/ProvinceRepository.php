<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\Province;
use Suitcore\Repositories\SuitRepository;

class ProvinceRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new Province;
    }
}
