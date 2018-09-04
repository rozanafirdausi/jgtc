<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\PerformerSchedule;
use App\SuitEvent\Repositories\PerformerScheduleRepository;
use View;

class PerformerScheduleController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  PerformerScheduleRepository $_baseRepo
     * @param  PerformerSchedule $_baseModel
     * @return void
     */
    public function __construct(PerformerScheduleRepository $_baseRepo, PerformerSchedule $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel, 'schedule');
        $this->routeBaseName = "backend.performerschedule";
        $this->routeDefaultIndex = "backend.schedule.show";
        $this->viewBaseClosure = "backend.admin.performerschedules";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'E1';
        View::share('pageId', $this->pageId);
        View::share('routeBaseName', $this->routeBaseName);
        View::share('routeDefaultIndex', $this->routeDefaultIndex);
        View::share('viewBaseClosure', $this->viewBaseClosure);
    }

    /**
     * Return json list of contentType
     * @param
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postIndexJson()
    {
        // Parameter
        $param = \Input::all();
        // Filter Parameter
        $specificFilter = [];
        if (isset($param['schedule_id'])) {
            $specificFilter['schedule_id'] = $param['schedule_id'];
        }
        // Return
        $menuSetting = [
            'session_token' => csrf_token(),
            'url_detail' => (
                \Route::
                has($this->routeBaseName . '.show') ? route($this->routeBaseName . '.show', ["id" => "#id#"]) : ''
            ),
            'url_edit' => (
                \Route::
                has($this->routeBaseName . '.edit') ? route($this->routeBaseName . '.edit', ["id" => "#id#"]) : ''
            ),
            'url_delete' => (
                \Route::
                has($this->routeBaseName . '.destroy') ? route($this->routeBaseName . '.destroy', ['id' => "#id#"]) : ''
            ),
        ];
        $renderedMenu = \View::make(self::$partialView[self::TABLE_MENU], ['menuSetting' => $menuSetting])->render();
        return $this->baseRepository->jsonDatatable($param, [
            'menu' => $renderedMenu
        ], $specificFilter);
    }

    /**
     * Index return route
     * @param int $id
     * @return \Illuminate\Support\Facades\Redirect
     */
    protected function returnToRootIndex($baseObj)
    {
        if (!empty($this->routeDefaultIndex)) {
            if (endsWith('.show', $this->routeDefaultIndex) &&
                !empty($this->topLevelRelationModelString)) {
                // custom detail return
                $topLevelRelationObject = $baseObj->getAttribute($this->topLevelRelationModelString);
                if ($topLevelRelationObject) {
                    return \Redirect::route($this->routeDefaultIndex, ['id' => $topLevelRelationObject->id]);
                }
            }
        }
        // Return if validation failed
        return \Redirect::back();
    }

    /**
     * Display baseModel create form
     * @param
     * @return \Illuminate\View\View
     */
    public function getCreate()
    {
        $baseObj = $this->baseModel;
        $scheduleId = \Input::get('schedule_id');
        if ($scheduleId && $scheduleId > 0) {
            $baseObj->schedule_id = $scheduleId;
            return view($this->viewBaseClosure . '.create')->with($this->viewInstanceName, $baseObj);
        }
        return $this->returnToRootIndex($baseObj);
    }

    /**
     * Save entry data from baseModel create form
     * @param
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function postCreate()
    {
        // Save
        $param = \Input::all();
        $param1 = [
            'schedule_id' => $param['schedule_id'],
            'performer_id' => $param['performer_id']
        ];
        $baseObj = $this->baseModel;
        $record = PerformerSchedule::where('schedule_id', $param['schedule_id'])
                                   ->where('performer_id', $param['performer_id'])
                                   ->first();
        if ($record) {
            $this->showNotification(
                self::ERROR_NOTIFICATION,
                $baseObj->_label . ' Created',
                'The performer already exist in this schedule, please add another performer!'
            );
            return \Redirect::route($this->routeBaseName . '.create')
            ->with('errors', $baseObj->errors)->withInput($param);
        } else {
            $result = $this->baseRepository->create($param, $baseObj);
        }
        // Return
        if ($result) {
            $this->showNotification(
                self::NOTICE_NOTIFICATION,
                $baseObj->_label . ' Created',
                'Successfully create new ' . strtolower($baseObj->_label) . '.'
            );
            return \Redirect::back();
        }
        $this->showNotification(self::ERROR_NOTIFICATION, $baseObj->_label . ' Created', $baseObj->errors->first());
        return \Redirect::route($this->routeBaseName . '.create')->with('errors', $baseObj->errors)->withInput($param);
    }
}
