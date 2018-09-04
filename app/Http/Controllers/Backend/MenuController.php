<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\DynamicMenu;
use App\SuitEvent\Repositories\DynamicMenuRepository;

class MenuController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  DynamicMenuRepository $_baseRepo
     * @param  DynamicMenu $_baseModel
     * @return void
     */
    public function __construct(
        DynamicMenuRepository $_baseRepo,
        DynamicMenu $_baseModel
    ) {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.menus";
        $this->routeDefaultIndex = "backend.menus.index";
        $this->viewBaseClosure = "backend.admin.menus";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'B0';
        \View::share('pageId', $this->pageId);
        \View::share('pageIcon', 'fa fa-map-signs');
        \View::share('routeBaseName', $this->routeBaseName);
        \View::share('routeDefaultIndex', $this->routeDefaultIndex);
        \View::share('viewBaseClosure', $this->viewBaseClosure);
    }
}
