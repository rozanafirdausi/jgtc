<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\City;
use App\SuitEvent\Repositories\CityRepository;
use Illuminate\Http\Request;
use Input;
use Response;
use Validator;

class CityController extends BaseController
{
    protected $defaultParams = [
        'orderBy' => 'position_order,name',
        'orderType' => 'asc'
    ];

    /**
     * Initialize
     *
     * @param CityRepository $repository
     * @param City           $model
     */
    public function __construct(
        CityRepository $repository,
        City $model
    ) {
        parent::__construct($repository, $model);
    }
}
