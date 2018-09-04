<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\City;
use App\SuitEvent\Repositories\CityRepository;
use File;
use Form;
use Input;
use MessageBag;
use Redirect;
use View;

class CityController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  CityRepository $_baseRepo
     * @param  City $_baseModel
     * @return void
     */
    public function __construct(CityRepository $_baseRepo, City $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.city";
        $this->routeDefaultIndex = "backend.city.index";
        $this->viewBaseClosure = "backend.admin.cities";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'I4';
        View::share('pageId', $this->pageId);
        View::share('pageIcon', 'fa fa-map-o');
        View::share('routeBaseName', $this->routeBaseName);
        View::share('routeDefaultIndex', $this->routeDefaultIndex);
        View::share('viewBaseClosure', $this->viewBaseClosure);
    }
}
