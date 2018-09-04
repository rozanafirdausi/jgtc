<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\DynamicMenu;
use Suitcore\Repositories\SuitRepository;

class DynamicMenuRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new DynamicMenu;
    }
}
