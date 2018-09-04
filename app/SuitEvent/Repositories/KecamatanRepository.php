<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\Kecamatan;
use Suitcore\Repositories\SuitRepository;

class KecamatanRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new Kecamatan;
    }
}
