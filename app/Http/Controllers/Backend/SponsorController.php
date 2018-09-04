<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\Sponsor;
use App\SuitEvent\Repositories\SponsorRepository;
use Input;
use Route;
use View;

class SponsorController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  SponsorRepository $_baseRepo
     * @param  Sponsor $_baseModel
     * @return void
     */
    public function __construct(SponsorRepository $_baseRepo, Sponsor $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.sponsor";
        $this->routeDefaultIndex = "backend.sponsor.index";
        $this->viewBaseClosure = "backend.admin.sponsors";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'F1';
        \View::share('pageId', $this->pageId);
        \View::share('pageIcon', 'fa fa-thumbs-up');
        \View::share('routeBaseName', $this->routeBaseName);
        \View::share('routeDefaultIndex', $this->routeDefaultIndex);
        \View::share('viewBaseClosure', $this->viewBaseClosure);
    }
}
