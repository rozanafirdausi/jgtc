<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\Discussion;
use App\SuitEvent\Repositories\DiscussionRepository;
use File;
use Form;
use Input;
use MessageBag;
use Redirect;
use View;

class DiscussionController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  DiscussionRepository $_baseRepo
     * @param  Discussion $_baseModel
     * @return void
     */
    public function __construct(DiscussionRepository $_baseRepo, Discussion $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.discussions";
        $this->routeDefaultIndex = "backend.discussions.index";
        $this->viewBaseClosure = "backend.admin.discussions";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'J2';
        View::share('pageId', $this->pageId);
        View::share('pageIcon', 'fa fa-comment');
        View::share('routeBaseName', $this->routeBaseName);
        View::share('routeDefaultIndex', $this->routeDefaultIndex);
        View::share('viewBaseClosure', $this->viewBaseClosure);
    }
}
