<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\ContentCategory;
use App\SuitEvent\Repositories\ContentCategoryRepository;
use File;
use Form;
use Input;
use MessageBag;
use Redirect;
use View;

class ContentCategoryController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  ContentCategoryRepository $_baseRepo
     * @param  ContentCategory $_baseModel
     * @return void
     */
    public function __construct(ContentCategoryRepository $_baseRepo, ContentCategory $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.contentcategory";
        $this->viewBaseClosure = "backend.admin.contentcategories";
        $this->viewInstanceName = 'contentCategory';
        // page ID
        $this->pageId = 'B1';
        View::share('pageId', $this->pageId);
    }
}
