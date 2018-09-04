<?php

namespace App\Http\Controllers\Backend;

use App;
use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\Content;
use App\SuitEvent\Models\ContentAttachment;
use App\SuitEvent\Repositories\ContentAttachmentRepository;
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

class ContentAttachmentController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  ContentAttachmentRepository $_baseRepo
     * @param  ContentAttachment $_baseModel
     * @return void
     */
    public function __construct(ContentAttachmentRepository $_baseRepo, ContentAttachment $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel, 'content');
        $this->routeBaseName = "backend.contentattachment";
        $this->routeDefaultIndex = "backend.content.show";
        $this->viewBaseClosure = "backend.admin.contentattachments";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'B2';
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
        $param = Input::all();
        // Filter Parameter
        $specificFilter = [];
        if (isset($param['content_id'])) {
            $specificFilter['content_id'] = $param['content_id'];
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
        $contentId = Input::get('content_id');
        if ($contentId && $contentId > 0) {
            $baseObj->content_id = $contentId;
            return view($this->viewBaseClosure . '.create')->with($this->viewInstanceName, $baseObj);
        }
        return $this->returnToRootIndex($baseObj);
    }
}
