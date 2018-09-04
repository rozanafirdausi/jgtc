<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\Participant;
use App\SuitEvent\Repositories\ParticipantRepository;
use Input;
use Route;
use View;

class ParticipantController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  ParticipantRepository $_baseRepo
     * @param  Participant $_baseModel
     * @return void
     */
    public function __construct(ParticipantRepository $_baseRepo, Participant $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.participant";
        $this->routeDefaultIndex = "backend.participant.index";
        $this->viewBaseClosure = "backend.admin.participants";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'H1';
        \View::share('pageId', $this->pageId);
        \View::share('pageIcon', 'fa fa-hand-peace-o');
        \View::share('routeBaseName', $this->routeBaseName);
        \View::share('routeDefaultIndex', $this->routeDefaultIndex);
        \View::share('viewBaseClosure', $this->viewBaseClosure);

        // Visible Config
        $_baseModel->setAttributeSettingsCustomState([
            'id',
            'type',
            'name',
            'email',
            'city_id',
            'position_order',
            'created_at',
            'updated_at'
        ]);
        $_baseModel->setBufferedAttributeSettings('type', 'options', $_baseModel->getTypeOptions());
    }
}
