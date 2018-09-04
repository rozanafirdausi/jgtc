<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\Gallery;
use App\SuitEvent\Repositories\GalleryRepository;
use Input;
use Route;
use View;

class GalleryController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  GalleryRepository $_baseRepo
     * @param  Gallery $_baseModel
     * @return void
     */
    public function __construct(GalleryRepository $_baseRepo, Gallery $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.gallery";
        $this->routeDefaultIndex = "backend.gallery.index";
        $this->viewBaseClosure = "backend.admin.galleries";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'G1';
        \View::share('pageId', $this->pageId);
        \View::share('pageIcon', 'fa fa-picture-o');
        \View::share('routeBaseName', $this->routeBaseName);
        \View::share('routeDefaultIndex', $this->routeDefaultIndex);
        \View::share('viewBaseClosure', $this->viewBaseClosure);
    }
}
