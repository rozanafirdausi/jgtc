<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\Sponsor;
use App\SuitEvent\Repositories\SponsorRepository;
use Illuminate\Http\Request;
use Input;
use Response;
use Validator;

class SponsorController extends BaseController
{
    protected $defaultParams = [
        'orderBy' => 'position_order,title',
        'orderType' => 'asc'
    ];

    /**
     * Initialize
     *
     * @param SponsorRepository $repository
     * @param Sponsor           $model
     */
    public function __construct(
        SponsorRepository $repository,
        Sponsor $model
    ) {
        parent::__construct($repository, $model);
    }
}
