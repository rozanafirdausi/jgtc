<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\Attraction;
use App\SuitEvent\Repositories\AttractionRepository;
use Input;
use Route;
use View;

class AttractionController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  AttractionRepository $_baseRepo
     * @param  Attraction $_baseModel
     * @return void
     */
    public function __construct(AttractionRepository $_baseRepo, Attraction $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.attraction";
        $this->routeDefaultIndex = "backend.attraction.index";
        $this->viewBaseClosure = "backend.admin.attractions";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'G2';
        \View::share('pageId', $this->pageId);
        \View::share('pageIcon', 'fa fa-eye');
        \View::share('routeBaseName', $this->routeBaseName);
        \View::share('routeDefaultIndex', $this->routeDefaultIndex);
        \View::share('viewBaseClosure', $this->viewBaseClosure);
    }
}
