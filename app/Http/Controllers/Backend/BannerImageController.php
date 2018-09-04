<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\BannerImage;
use App\SuitEvent\Repositories\BannerImageRepository;
use File;
use Form;
use Input;
use MessageBag;
use Redirect;
use Route;
use View;

class BannerImageController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  BannerImageRepository $_baseRepo
     * @param  BannerImage $_baseModel
     * @return void
     */
    public function __construct(BannerImageRepository $_baseRepo, BannerImage $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.bannerimages";
        $this->routeDefaultIndex = "backend.bannerimages.index";
        $this->viewBaseClosure = "backend.admin.bannerimages";
        $this->viewExtendedInstanceName = 'extendedObject';
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'B4';
        View::share('pageId', $this->pageId);
        View::share('pageIcon', 'fa fa-picture-o');
        View::share('routeBaseName', $this->routeBaseName);
        View::share('routeDefaultIndex', $this->routeDefaultIndex);
        View::share('viewBaseClosure', $this->viewBaseClosure);

        $_baseModel->setBufferedAttributeSettings('text', 'visible', false);
        $_baseModel->setBufferedAttributeSettings('text', 'type', BannerImage::TYPE_TEXTAREA);
        $_baseModel->setBufferedAttributeSettings('title', 'required', false);
        $_baseModel->setBufferedAttributeSettings('text', 'required', false);
        $_baseModel->setBufferedAttributeSettings('url', 'required', false);
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
            'type' => [
                BannerImage::TYPE_MAIN => "<span class='label label-blue label-primary'>#type#</span>",
                BannerImage::TYPE_SIDE => "<span class='label label--lime label-warning'>#type#</span>"
            ],
            'status' => [
                BannerImage::STATUS_ACTIVE => "<span class='label label--green label-success'>#status#</span>",
                BannerImage::STATUS_TIMED => "<span class='label label--blue label-info'>#status#</span>",
                BannerImage::STATUS_INACTIVE => "<span class='label label--red label-danger'>#status#</span>"
            ],
            'menu' => $renderedMenu
        ]);
    }
}
