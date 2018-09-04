<?php

namespace App\Http\Controllers\Backend;

use App;
use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\PerformerCandidate;
use App\SuitEvent\Repositories\PerformerCandidateRepository;
use Input;
use Redirect;
use Route;
use View;

class PerformerCandidateController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  PerformerCandidateRepository $_baseRepo
     * @param  PerformerCandidate $_baseModel
     * @return void
     */
    public function __construct(PerformerCandidateRepository $_baseRepo, PerformerCandidate $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.performer-candidate";
        $this->routeDefaultIndex = "backend.performer-candidate.index";
        $this->viewBaseClosure = "backend.admin.performer-candidates";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'D2';
        \View::share('pageId', $this->pageId);
        \View::share('pageIcon', 'fa fa-male');
        \View::share('routeBaseName', $this->routeBaseName);
        \View::share('routeDefaultIndex', $this->routeDefaultIndex);
        \View::share('viewBaseClosure', $this->viewBaseClosure);
    }

    public function postCreate()
    {
        // Save
        $param = Input::all();
        $baseObj = $this->baseModel;
        if ($param['type'] != 'collab') {
            $param['collab_type'] = null;
        }
        $result = $this->baseRepository->create($param, $baseObj);
        if ($baseObj->uploadError) {
            $this->showNotification(
                self::
                ERROR_NOTIFICATION,
                $baseObj->_label . trans('suitcore.backend.create.upload.error.title'),
                trans(
                    'suitcore.backend.create.upload.error.message',
                    ['obj' => strtolower($baseObj->_label)]
                )
            );
        }
        // Return
        if ($result) {
            $this->showNotification(
                self::
                NOTICE_NOTIFICATION,
                $baseObj->_label . ' Created',
                'Successfully create new ' . strtolower($baseObj->_label) . '.'
            );
            if (Route::has($this->routeBaseName . '.show')) {
                return Redirect::route($this->routeBaseName . '.show', ['id' => $baseObj->id]);
            } else {
                return $this->returnToRootIndex($baseObj);
            }
        }
        $this->showNotification(
            self::
            ERROR_NOTIFICATION,
            $baseObj->_label . ' Not Created',
            $baseObj->errors->first()
        );
        return Redirect::route($this->routeBaseName . '.create')->with('errors', $baseObj->errors)->withInput($param);
    }

    public function postUpdate($id)
    {
        // Save
        $param = Input::all();
        $baseObj = $this->baseModel;
        if ($param['type'] != 'collab') {
            $param['collab_type'] = null;
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
        $this->showNotification(
            self::
            ERROR_NOTIFICATION,
            $baseObj->_label . ' Not Updated',
            $baseObj->errors->first()
        );
        return Redirect::
        route($this->routeBaseName . '.update', ['id' => $id])->with('errors', $baseObj->errors)->withInput($param);
    }
}
