<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\PerformerReview;
use App\SuitEvent\Repositories\PerformerReviewRepository;
use View;

class PerformerReviewController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  PerformerReviewRepository $_baseRepo
     * @param  PerformerReview $_baseModel
     * @return void
     */
    public function __construct(PerformerReviewRepository $_baseRepo, PerformerReview $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel, 'performer');
        $this->routeBaseName = "backend.performerreview";
        $this->routeDefaultIndex = "backend.performer.show";
        $this->viewBaseClosure = "backend.admin.performerreviews";
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
        $performerId = \Input::get('performer_id');
        if ($performerId && $performerId > 0) {
            $baseObj->performer_id = $performerId;
            return view($this->viewBaseClosure . '.create')->with($this->viewInstanceName, $baseObj);
        }
        return $this->returnToRootIndex($baseObj);
    }
}
