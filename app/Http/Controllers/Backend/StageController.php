<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\Stage;
use App\SuitEvent\Repositories\StageRepository;
use Input;
use Route;
use View;

class StageController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  StageRepository $_baseRepo
     * @param  Stage $_baseModel
     * @return void
     */
    public function __construct(StageRepository $_baseRepo, Stage $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.stage";
        $this->routeDefaultIndex = "backend.stage.index";
        $this->viewBaseClosure = "backend.admin.stages";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'E2';
        \View::share('pageId', $this->pageId);
        \View::share('pageIcon', 'fa fa-male');
        \View::share('routeBaseName', $this->routeBaseName);
        \View::share('routeDefaultIndex', $this->routeDefaultIndex);
        \View::share('viewBaseClosure', $this->viewBaseClosure);
    }
}
