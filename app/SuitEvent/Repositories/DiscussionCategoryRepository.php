<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\DiscussionCategory;
use Suitcore\Repositories\SuitRepository;

class DiscussionCategoryRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new DiscussionCategory;
    }
}
