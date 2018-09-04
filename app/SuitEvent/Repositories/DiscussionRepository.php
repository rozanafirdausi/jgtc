<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\Discussion;
use Suitcore\Repositories\SuitRepository;

class DiscussionRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new Discussion;
    }
}
