<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\Faq;
use App\SuitEvent\Repositories\FaqRepository;
use File;
use Form;
use Input;
use MessageBag;
use Redirect;
use View;

class FaqController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  FaqRepository $_baseRepo
     * @param  Faq $_baseModel
     * @return void
     */
    public function __construct(FaqRepository $_baseRepo, Faq $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.faq";
        $this->routeDefaultIndex = "backend.faq.index";
        $this->viewBaseClosure = "backend.admin.faqs";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'B3';
        \View::share('pageId', $this->pageId);
        \View::share('pageIcon', 'fa fa-question-circle');
        \View::share('routeBaseName', $this->routeBaseName);
        \View::share('routeDefaultIndex', $this->routeDefaultIndex);
        \View::share('viewBaseClosure', $this->viewBaseClosure);
    }
}
