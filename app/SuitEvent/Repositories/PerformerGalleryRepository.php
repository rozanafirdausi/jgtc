<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\PerformerGallery;
use Suitcore\Repositories\SuitRepository;

class PerformerGalleryRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new PerformerGallery;
    }
}
