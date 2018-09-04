<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Models\User;
use App\SuitEvent\Repositories\DashboardRepository;
use Carbon\Carbon;
use Response;
use View;

class HomeController extends BaseController
{
    /**
     * Override Default Constructor
     * @param  ProductRepository $_baseRepo
     * @param  Product $_baseModel
     * @return void
     */
    public function __construct(DashboardRepository $_baseRepo, User $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.home";
        $this->routeDefaultIndex = "backend.home.index";
        $this->viewBaseClosure = "backend.admin";
        $this->viewInstanceName = 'Overview';
        // page ID
        $this->pageId = 'A1';
        View::share('pageTitle', $this->viewInstanceName);
        View::share('pageId', $this->pageId);
        View::share('routeBaseName', $this->routeBaseName);
        View::share('routeDefaultIndex', $this->routeDefaultIndex);
        View::share('viewBaseClosure', $this->viewBaseClosure);
    }

    // Show Dashboard
    public function getIndex()
    {
        return \View::make('backend.admin.dashboard');
    }

    public function pattern()
    {
        return view('backend.admin.pattern');
    }
}
