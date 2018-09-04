<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\Schedule;
use App\SuitEvent\Repositories\ScheduleRepository;
use Input;
use Route;
use View;

class ScheduleController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  ScheduleRepository $_baseRepo
     * @param  Schedule $_baseModel
     * @return void
     */
    public function __construct(ScheduleRepository $_baseRepo, Schedule $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.schedule";
        $this->routeDefaultIndex = "backend.schedule.index";
        $this->viewBaseClosure = "backend.admin.schedules";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'E1';
        \View::share('pageId', $this->pageId);
        \View::share('pageIcon', 'fa fa-sort-numeric-asc');
        \View::share('routeBaseName', $this->routeBaseName);
        \View::share('routeDefaultIndex', $this->routeDefaultIndex);
        \View::share('viewBaseClosure', $this->viewBaseClosure);

        // Visible Config
        $_baseModel->setAttributeSettingsCustomState([
            'id',
            'event_type',
            'title',
            'description',
            'image',
            'banner',
            'stage_id',
            'location',
            'start_date',
            'end_date',
            //'total_rate'
            //'max_participant'
            //'num_participant'
            //'position_order',
            'is_visible',
            'created_at',
            'updated_at'
        ]);
        $_baseModel->setBufferedAttributeSettings('id', 'visible', false);
    }
}
