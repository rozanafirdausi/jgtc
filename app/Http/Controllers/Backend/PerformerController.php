<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\Performer;
use App\SuitEvent\Repositories\PerformerRepository;
use Input;
use Route;
use View;

class PerformerController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  PerformerRepository $_baseRepo
     * @param  Performer $_baseModel
     * @return void
     */
    public function __construct(PerformerRepository $_baseRepo, Performer $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.performer";
        $this->routeDefaultIndex = "backend.performer.index";
        $this->viewBaseClosure = "backend.admin.performers";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'D1';
        \View::share('pageId', $this->pageId);
        \View::share('pageIcon', 'fa fa-male');
        \View::share('routeBaseName', $this->routeBaseName);
        \View::share('routeDefaultIndex', $this->routeDefaultIndex);
        \View::share('viewBaseClosure', $this->viewBaseClosure);

        // Visible Config
        $_baseModel->setAttributeSettingsCustomState([
            'id',
            'name',
            'description',
            'type',
            'position_order',
            'avatar',
            'mobile_video_url',
            //'job_title',
            //'institution',
            //'email',
            'average_rate',
            'is_visible',
            'created_at',
            'updated_at'
        ]);
        $_baseModel->setBufferedAttributeSettings('id', 'visible', true);
        $_baseModel->setBufferedAttributeSettings('text', 'type', Performer::TYPE_TEXT);
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
                Performer::TYPE_INTERNATIONAL => "<span class='label label-blue label-primary'>#type#</span>",
                Performer::TYPE_NATIONAL => "<span class='label label--lime label-warning'>#type#</span>"
            ],
            'menu' => $renderedMenu
        ]);
    }
}
