<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\DiscussionCategory;
use App\SuitEvent\Repositories\DiscussionCategoryRepository;
use File;
use Form;
use Input;
use MessageBag;
use Redirect;
use View;

class DiscussionCategoryController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  DiscussionCategoryRepository $_baseRepo
     * @param  DiscussionCategory $_baseModel
     * @return void
     */
    public function __construct(DiscussionCategoryRepository $_baseRepo, DiscussionCategory $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.discussioncategories";
        $this->routeDefaultIndex = "backend.discussioncategories.index";
        $this->viewBaseClosure = "backend.admin.discussioncategories";
        $this->viewInstanceName = 'baseObject';

        // page ID
        $this->pageId = 'J1';
        View::share('pageId', $this->pageId);
        View::share('pageIcon', 'fa fa-tag');
        View::share('routeBaseName', $this->routeBaseName);
        View::share('routeDefaultIndex', $this->routeDefaultIndex);
        View::share('viewBaseClosure', $this->viewBaseClosure);
    }
}
