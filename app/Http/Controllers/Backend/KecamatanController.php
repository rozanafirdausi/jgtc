<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\Kecamatan;
use App\SuitEvent\Repositories\KecamatanRepository;
use File;
use Form;
use Input;
use MessageBag;
use Redirect;
use View;

class KecamatanController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  KecamatanRepository $_baseRepo
     * @param  Kecamatan $_baseModel
     * @return void
     */
    public function __construct(KecamatanRepository $_baseRepo, Kecamatan $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.kecamatan";
        $this->routeDefaultIndex = "backend.kecamatan.index";
        $this->viewBaseClosure = "backend.admin.kecamatans";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'I5';
        View::share('pageId', $this->pageId);
        View::share('pageIcon', 'fa fa-map-o');
        View::share('routeBaseName', $this->routeBaseName);
        View::share('routeDefaultIndex', $this->routeDefaultIndex);
        View::share('viewBaseClosure', $this->viewBaseClosure);
    }
}
