<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\ParticipantAnswer;
use App\SuitEvent\Repositories\ParticipantAnswerRepository;
use Input;
use Route;
use View;

class ParticipantAnswerController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  ParticipantAnswerRepository $_baseRepo
     * @param  ParticipantAnswer $_baseModel
     * @return void
     */
    public function __construct(ParticipantAnswerRepository $_baseRepo, ParticipantAnswer $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel, 'ParticipantAnswer');
        $this->routeBaseName = "backend.participantanswer";
        $this->routeDefaultIndex = "backend.participantanswer.index";
        $this->viewBaseClosure = "backend.admin.participantanswers";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'F2';
        \View::share('pageId', $this->pageId);
        \View::share('pageIcon', 'fa fa-hand-peace-o');
        \View::share('routeBaseName', $this->routeBaseName);
        \View::share('routeDefaultIndex', $this->routeDefaultIndex);
        \View::share('viewBaseClosure', $this->viewBaseClosure);
    }

    /**
     * Return json list
     * @param
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postIndexJson()
    {
        // Parameter
        $param = Input::all();
        // Filter Parameter
        $specificFilter = [];
        if (isset($param['participant_id'])) {
            $specificFilter['participant_id'] = $param['participant_id'];
        }
        // Return
        $menuSetting = [
            'session_token' => csrf_token(),
            'url_detail' => (
                Route::
                has($this->routeBaseName . '.show') ? route($this->routeBaseName . '.show', ["id" => "#id#"]) : ''
            ),
            'url_edit' => (
                Route::
                has($this->routeBaseName . '.edit') ? route($this->routeBaseName . '.edit', ["id" => "#id#"]) : ''
            ),
            'url_delete' => (
                Route::
                has($this->routeBaseName . '.destroy') ? route($this->routeBaseName . '.destroy', ['id' => "#id#"]) : ''
            ),
        ];
        $renderedMenu = View::make(self::$partialView[self::TABLE_MENU], ['menuSetting' => $menuSetting])->render();
        return $this->baseRepository->jsonDatatable($param, [
            'menu' => $renderedMenu
        ], $specificFilter);
    }
}
