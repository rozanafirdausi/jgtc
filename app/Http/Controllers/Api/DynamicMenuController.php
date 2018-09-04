<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\DynamicMenu;
use App\SuitEvent\Repositories\DynamicMenuRepository;
use Illuminate\Http\Request;
use Input;
use Response;
use Validator;

class DynamicMenuController extends BaseController
{
    protected $defaultParams = [
        'orderBy' => 'position_order,label',
        'orderType' => 'asc'
    ];

    /**
     * Initialize
     *
     * @param DynamicMenuRepository $repository
     * @param DynamicMenu           $model
     */
    public function __construct(
        DynamicMenuRepository $repository,
        DynamicMenu $model
    ) {
        parent::__construct($repository, $model);
    }
}
