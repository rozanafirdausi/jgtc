<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\EventReview;
use App\SuitEvent\Repositories\EventReviewRepository;
use Input;
use Route;
use View;

class EventReviewController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  EventReviewRepository $_baseRepo
     * @param  EventReview $_baseModel
     * @return void
     */
    public function __construct(EventReviewRepository $_baseRepo, EventReview $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.eventreview";
        $this->routeDefaultIndex = "backend.eventreview.index";
        $this->viewBaseClosure = "backend.admin.eventreviews";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'H4';
        \View::share('pageId', $this->pageId);
        \View::share('pageIcon', 'fa fa-star');
        \View::share('routeBaseName', $this->routeBaseName);
        \View::share('routeDefaultIndex', $this->routeDefaultIndex);
        \View::share('viewBaseClosure', $this->viewBaseClosure);
    }
}
