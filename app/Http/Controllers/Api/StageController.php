<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\Stage;
use App\SuitEvent\Repositories\StageRepository;

class StageController extends BaseController
{
    protected $defaultParams = [
        'orderBy' => 'position_order,name',
        'orderType' => 'asc'
    ];

    /**
     * Initialize
     *
     * @param StageRepository $repository
     * @param Stage           $model
     */
    public function __construct(
        StageRepository $repository,
        Stage $model
    ) {
        parent::__construct($repository, $model);
    }
}
