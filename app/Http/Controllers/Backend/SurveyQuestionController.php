<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\SurveyQuestion;
use App\SuitEvent\Repositories\SurveyQuestionRepository;
use Input;
use Route;
use View;

class SurveyQuestionController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  SurveyQuestionRepository $_baseRepo
     * @param  SurveyQuestion $_baseModel
     * @return void
     */
    public function __construct(SurveyQuestionRepository $_baseRepo, SurveyQuestion $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.surveyquestion";
        $this->routeDefaultIndex = "backend.surveyquestion.index";
        $this->viewBaseClosure = "backend.admin.surveyquestions";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'H2';
        \View::share('pageId', $this->pageId);
        \View::share('pageIcon', 'fa fa-question-circle-o');
        \View::share('routeBaseName', $this->routeBaseName);
        \View::share('routeDefaultIndex', $this->routeDefaultIndex);
        \View::share('viewBaseClosure', $this->viewBaseClosure);
    }
}
