<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\Attraction;
use App\SuitEvent\Repositories\AttractionRepository;

class AttractionController extends BaseController
{
    /**
     * Initialize
     *
     * @param AttractionRepository $repository
     * @param Schedule           $model
     */
    public function __construct(
        AttractionRepository $repository,
        Attraction $model
    ) {
        parent::__construct($repository, $model);
    }
}
