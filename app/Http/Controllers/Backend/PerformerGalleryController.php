<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\PerformerGallery;
use App\SuitEvent\Repositories\PerformerGalleryRepository;
use View;

class PerformerGalleryController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  PerformerGalleryRepository $_baseRepo
     * @param  PerformerGallery $_baseModel
     * @return void
     */
    public function __construct(PerformerGalleryRepository $_baseRepo, PerformerGallery $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel, 'gallery');
        $this->routeBaseName = "backend.performergallery";
        $this->routeDefaultIndex = "backend.gallery.show";
        $this->viewBaseClosure = "backend.admin.performergalleries";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'G1';
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
        if (isset($param['gallery_id'])) {
            $specificFilter['gallery_id'] = $param['gallery_id'];
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
        $galleryId = \Input::get('gallery_id');
        if ($galleryId && $galleryId > 0) {
            $baseObj->gallery_id = $galleryId;
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
            'gallery_id' => $param['gallery_id'],
            'performer_id' => $param['performer_id']
        ];
        $baseObj = $this->baseModel;
        $record = PerformerGallery::where('gallery_id', $param['gallery_id'])
                                   ->where('performer_id', $param['performer_id'])
                                   ->first();
        if ($record) {
            $this->showNotification(
                self::ERROR_NOTIFICATION,
                $baseObj->_label . ' Created',
                'The performer already exist in this gallery, please add another performer!'
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
