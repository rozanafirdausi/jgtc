<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\Kelurahan;
use App\SuitEvent\Repositories\KelurahanRepository;
use File;
use Form;
use Input;
use MessageBag;
use Redirect;
use View;

class KelurahanController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  KelurahanRepository $_baseRepo
     * @param  Kelurahan $_baseModel
     * @return void
     */
    public function __construct(KelurahanRepository $_baseRepo, Kelurahan $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.kelurahan";
        $this->routeDefaultIndex = "backend.kelurahan.index";
        $this->viewBaseClosure = "backend.admin.kelurahans";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'I6';
        View::share('pageId', $this->pageId);
        View::share('pageIcon', 'fa fa-map-o');
        View::share('routeBaseName', $this->routeBaseName);
        View::share('routeDefaultIndex', $this->routeDefaultIndex);
        View::share('viewBaseClosure', $this->viewBaseClosure);
    }
}
