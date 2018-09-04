<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\Province;
use App\SuitEvent\Repositories\ProvinceRepository;
use File;
use Form;
use Input;
use MessageBag;
use Redirect;
use View;

class ProvinceController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  ProvinceRepository $_baseRepo
     * @param  Province $_baseModel
     * @return void
     */
    public function __construct(ProvinceRepository $_baseRepo, Province $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.province";
        $this->routeDefaultIndex = "backend.province.index";
        $this->viewBaseClosure = "backend.admin.provinces";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'I3';
        View::share('pageId', $this->pageId);
        View::share('pageIcon', 'fa fa-map-o');
        View::share('routeBaseName', $this->routeBaseName);
        View::share('routeDefaultIndex', $this->routeDefaultIndex);
        View::share('viewBaseClosure', $this->viewBaseClosure);
    }
}
