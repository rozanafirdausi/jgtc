<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\Discussion;
use App\SuitEvent\Repositories\DiscussionRepository;
use Illuminate\Http\Request;
use Input;
use Response;
use Validator;

class DiscussionController extends BaseController
{
    protected $defaultParams = [
        'orderBy' => 'created_at',
        'orderType' => 'desc'
    ];

    /**
     * Initialize
     *
     * @param DiscussionRepository $repository
     * @param Discussion           $model
     */
    public function __construct(
        DiscussionRepository $repository,
        Discussion $model
    ) {
        parent::__construct($repository, $model);
    }
}
