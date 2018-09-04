<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\SurveyAnswer;
use App\SuitEvent\Repositories\SurveyAnswerRepository;
use Input;
use Route;
use View;

class SurveyAnswerController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  SurveyAnswerRepository $_baseRepo
     * @param  SurveyAnswer $_baseModel
     * @return void
     */
    public function __construct(SurveyAnswerRepository $_baseRepo, SurveyAnswer $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.surveyanswer";
        $this->routeDefaultIndex = "backend.surveyanswer.index";
        $this->viewBaseClosure = "backend.admin.surveyanswers";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'H3';
        \View::share('pageId', $this->pageId);
        \View::share('pageIcon', 'fa fa-question-circle-o');
        \View::share('routeBaseName', $this->routeBaseName);
        \View::share('routeDefaultIndex', $this->routeDefaultIndex);
        \View::share('viewBaseClosure', $this->viewBaseClosure);
    }
}
