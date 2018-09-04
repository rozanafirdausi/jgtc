<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\Content;
use App\SuitEvent\Repositories\ContentRepository;
use File;
use Form;
use Input;
use MessageBag;
use Redirect;
use View;

class ContentController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  ContentRepository $_baseRepo
     * @param  Content $_baseModel
     * @return void
     */
    public function __construct(ContentRepository $_baseRepo, Content $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.content";
        $this->routeDefaultIndex = "backend.content.index";
        $this->viewBaseClosure = "backend.admin.contents";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'B2';
        \View::share('pageId', $this->pageId);
        \View::share('pageIcon', 'fa fa-file-code-o');
        \View::share('routeBaseName', $this->routeBaseName);
        \View::share('routeDefaultIndex', $this->routeDefaultIndex);
        \View::share('viewBaseClosure', $this->viewBaseClosure);

        // Visible Config
        $_baseModel->setAttributeSettingsCustomState([
            'id',
            'type_id',
            'title',
            'slug',
            'highlight',
            'content',
            'image',
            'attachment_file',
            'status',
            'created_at',
            'updated_at'
        ]);

        $_baseModel->setBufferedAttributeSettings('category_id', 'formdisplay', false);
    }
}
