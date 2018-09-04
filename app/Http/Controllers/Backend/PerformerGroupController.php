<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\PerformerGroup;
use App\SuitEvent\Repositories\PerformerGroupRepository;
use Input;
use Redirect;
use Route;
use View;

class PerformerGroupController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  PerformerGroupRepository $_baseRepo
     * @param  PerformerGroup $_baseModel
     * @return void
     */
    public function __construct(PerformerGroupRepository $_baseRepo, PerformerGroup $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel, 'performer1');
        $this->routeBaseName = "backend.performer-group";
        $this->routeDefaultIndex = "backend.performer-candidate.show";
        $this->viewBaseClosure = "backend.admin.performer-groups";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'D3';
        \View::share('pageId', $this->pageId);
        \View::share('pageIcon', 'fa fa-users');
        \View::share('routeBaseName', $this->routeBaseName);
        \View::share('routeDefaultIndex', $this->routeDefaultIndex);
        \View::share('viewBaseClosure', $this->viewBaseClosure);
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
        if (isset($param['performer_1_id'])) {
            $specificFilter['performer_1_id'] = $param['performer_1_id'];
        }
        // Return
        $menuSetting = [
            'session_token' => csrf_token(),
            'url_detail' => (\Route::
                has($this->routeBaseName . '.show') ? route($this->routeBaseName . '.show', ["id" => "#id#"]) : ''),
            'url_edit' => (\Route::
            has($this->routeBaseName . '.edit') ? route($this->routeBaseName . '.edit', ["id" => "#id#"]) : ''),
            'url_delete' => (\Route::
            has($this->routeBaseName . '.destroy') ? route($this->routeBaseName . '.destroy', ['id' => "#id#"]) : ''),
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
                    return Redirect::route($this->routeDefaultIndex, ['id' => $topLevelRelationObject->id]);
                }
            }
        }
        // Return if validation failed
        return Redirect::back();
    }

    /**
     * Display baseModel create form
     * @param
     * @return \Illuminate\View\View
     */
    public function getCreate()
    {
        $baseObj = $this->baseModel;
        $performerId = Input::get('performer_1_id');
        if ($performerId && $performerId > 0) {
            $baseObj->performer_1_id = $performerId;
            return view($this->viewBaseClosure . '.create')->with($this->viewInstanceName, $baseObj);
        }
        return $this->returnToRootIndex($baseObj);
    }

    public function postCreate()
    {
        // Save
        $param = Input::all();
        $param1 = [
            'performer_1_id' => $param['performer_1_id'],
            'performer_2_id' => $param['performer_2_id']
        ];
        $baseObj = $this->baseModel;
        $result = PerformerGroup::firstOrCreate($param1);
        // Return
        if ($result) {
            $this->showNotification(
                self::
                NOTICE_NOTIFICATION,
                $baseObj->_label . ' Created',
                'Successfully create new ' . strtolower(
                    $baseObj->_label
                ) . '.'
            );
            if (Route::has($this->routeBaseName . '.show')) {
                return Redirect::route($this->routeBaseName . '.show', ['id' => $baseObj->id]);
            } else {
                return $this->returnToRootIndex($baseObj);
            }
        }
        $this->showNotification(self::ERROR_NOTIFICATION, $baseObj->_label . ' Created', $baseObj->errors->first());
        return Redirect::route($this->routeBaseName . '.create')->with('errors', $baseObj->errors)->withInput($param);
    }
}
