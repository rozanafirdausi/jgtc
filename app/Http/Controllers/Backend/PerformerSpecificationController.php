<?php

namespace App\Http\Controllers\Backend;

use App;
use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\Performer;
use App\SuitEvent\Models\PerformerSpecification;
use App\SuitEvent\Repositories\PerformerSpecificationRepository;
use DB;
use File;
use Form;
use Input;
use MessageBag;
use Redirect;
use Request;
use Response;
use Route;
use View;

class PerformerSpecificationController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  PerformerSpecificationRepository $_baseRepo
     * @param  PerformerSpecification $_baseModel
     * @return void
     */
    public function __construct(PerformerSpecificationRepository $_baseRepo, PerformerSpecification $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel, 'performer');
        $this->routeBaseName = "backend.performerspec";
        $this->routeDefaultIndex = "backend.performer.show";
        $this->viewBaseClosure = "backend.admin.performerspecs";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'D1';
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
        if (isset($param['performer_id'])) {
            $specificFilter['performer_id'] = $param['performer_id'];
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
        $performerId = Input::get('performer_id');
        if ($performerId && $performerId > 0) {
            $baseObj->performer_id = $performerId;
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
        $param = Input::all();
        $baseObj = $this->baseModel;
        $object = PerformerSpecification::where('performer_id', $param['performer_id'])
                                        ->where('key', $param['key'])
                                        ->first();
        if ($object) {
            $this->showNotification(
                self::
                ERROR_NOTIFICATION,
                $baseObj->_label . ' Created',
                'Data dengan key tersebut sudah ada pada database, silahkan gunakan key yang lain.'
            );
            return Redirect::back()->with('errors', $baseObj->errors)->withInput($param);
        }
        $result = $this->baseRepository->create($param, $baseObj);
        // Return
        if ($result) {
            $this->showNotification(
                self::
                NOTICE_NOTIFICATION,
                $baseObj->_label . ' Created',
                'Successfully create new ' . strtolower($baseObj->_label) . '.'
            );
            return Redirect::back();
        }
        $this->showNotification(
            self::
            ERROR_NOTIFICATION,
            $baseObj->_label . ' Created',
            $baseObj->errors->first()
        );
        return Redirect::route($this->routeBaseName . '.create')->with('errors', $baseObj->errors)->withInput($param);
    }

    public function postUpdate($id)
    {
        // Save
        $param = Input::all();
        $baseObj = $this->baseModel;
        $object = PerformerSpecification::where('performer_id', $param['performer_id'])
                                        ->where('key', $param['key'])
                                        ->where('id', '<>', $id)
                                        ->first();
        if ($object) {
            $this->showNotification(
                self::
                ERROR_NOTIFICATION,
                $baseObj->_label . ' Created',
                'Data dengan key tersebut sudah ada pada database, silahkan gunakan key yang lain.'
            );
            return Redirect::back()->with('errors', $baseObj->errors)->withInput($param);
        }
        $result = $this->baseRepository->update($id, $param, $baseObj);
        if ($baseObj->uploadError) {
            $this->showNotification(
                self::
                ERROR_NOTIFICATION,
                $baseObj->_label . trans('suitcore.backend.update.upload.error.title'),
                trans('suitcore.backend.update.upload.error.message', ['obj' => strtolower($baseObj->_label)])
            );
        }
        // Return
        if ($result) {
            $this->showNotification(
                self::
                NOTICE_NOTIFICATION,
                $baseObj->_label . ' Updated',
                'Successfully update ' . strtolower($baseObj->_label) . '.'
            );
            if (Route::has($this->routeBaseName . '.show')) {
                return Redirect::route($this->routeBaseName . '.show', ['id' => $id]);
            } else {
                return $this->returnToRootIndex($baseObj);
            }
        }
        if ($baseObj == null) {
            App::abort(404);
        }
        $this->showNotification(self::ERROR_NOTIFICATION, $baseObj->_label . ' Not Updated', $baseObj->errors->first());
        return Redirect::
        route(
            $this->routeBaseName . '.update',
            ['id' => $id]
        )->with('errors', $baseObj->errors)->withInput($param);
    }
}
