<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\Faq;
use Suitcore\Repositories\SuitRepository;

class FaqRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new Faq;
    }
}
