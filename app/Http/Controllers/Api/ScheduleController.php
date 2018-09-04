<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\Schedule;
use App\SuitEvent\Repositories\ScheduleRepository;

class ScheduleController extends BaseController
{
    protected $defaultParams = [
        'orderBy' => 'start_date',
        'orderType' => 'asc'
    ];

    protected $objectDependencies = [
        'performers'
    ];

    protected $defaultSettings = [
        'optional_dependency' => ['performers']
    ];

    /**
     * Initialize
     *
     * @param ScheduleRepository $repository
     * @param Schedule           $model
     */
    public function __construct(
        ScheduleRepository $repository,
        Schedule $model
    ) {
        parent::__construct($repository, $model);
    }
}
