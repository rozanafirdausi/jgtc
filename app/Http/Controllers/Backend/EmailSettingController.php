<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\EmailSetting;
use App\SuitEvent\Repositories\EmailSettingRepository;

class EmailSettingController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  DynamicMenuRepository $_baseRepo
     * @param  DynamicMenu $_baseModel
     * @return void
     */
    public function __construct(
        EmailSettingRepository $_baseRepo,
        EmailSetting $_baseModel
    ) {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.emailsettings";
        $this->routeDefaultIndex = "backend.emailsettings.index";
        $this->viewBaseClosure = "backend.admin.emailsettings";
        $this->viewInstanceName = 'baseObject';
        $this->menuRepo = $_baseRepo;
        // page ID
        $this->pageId = 'B8';
        \View::share('pageId', $this->pageId);
        \View::share('pageIcon', 'fa fa-envelope');
        \View::share('routeBaseName', $this->routeBaseName);
        \View::share('routeDefaultIndex', $this->routeDefaultIndex);
        \View::share('viewBaseClosure', $this->viewBaseClosure);
    }
}
