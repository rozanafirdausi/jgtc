<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\ContentType;
use App\SuitEvent\Repositories\ContentTypeRepository;
use File;
use Form;
use Input;
use MessageBag;
use Redirect;
use View;

class ContentTypeController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  ContentTypeRepository $_baseRepo
     * @param  ContentType $_baseModel
     * @return void
     */
    public function __construct(ContentTypeRepository $_baseRepo, ContentType $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.contenttype";
        $this->viewBaseClosure = "backend.admin.contenttypes";
        $this->viewInstanceName = 'contentType';
        // page ID
        $this->pageId = 'B1';
        View::share('pageId', $this->pageId);
    }
}
