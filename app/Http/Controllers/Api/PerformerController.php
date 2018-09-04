<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\Performer;
use App\SuitEvent\Repositories\PerformerRepository;
use Input;

class PerformerController extends BaseController
{
    protected $defaultParams = [
        'orderBy' => 'position_order,name',
        'orderType' => 'asc'
    ];

    protected $objectDependencies = [
        'specifications',
        'schedules'
    ];

    protected $defaultSettings = [
        'optional_dependency' => ['specifications', 'schedules']
    ];

    /**
     * Initialize
     *
     * @param PerformerRepository $repository
     * @param Performer           $model
     */
    public function __construct(
        PerformerRepository $repository,
        Performer $model
    ) {
        parent::__construct($repository, $model);
    }
}
