<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\Gallery;
use Suitcore\Repositories\SuitRepository;

class GalleryRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new Gallery;
    }
}
