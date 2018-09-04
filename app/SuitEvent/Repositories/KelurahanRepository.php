<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\Kelurahan;
use Suitcore\Repositories\SuitRepository;

class KelurahanRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new Kelurahan;
    }
}
