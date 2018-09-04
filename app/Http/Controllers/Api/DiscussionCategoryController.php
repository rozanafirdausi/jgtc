<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\DiscussionCategory;
use App\SuitEvent\Repositories\DiscussionCategoryRepository;
use Illuminate\Http\Request;
use Input;
use Response;
use Validator;

class DiscussionCategoryController extends BaseController
{
    protected $defaultParams = [
        'orderBy' => 'created_at',
        'orderType' => 'desc'
    ];

    /**
     * Initialize
     *
     * @param DiscussionCategoryRepository $repository
     * @param DiscussionCategory           $model
     */
    public function __construct(
        DiscussionCategoryRepository $repository,
        DiscussionCategory $model
    ) {
        parent::__construct($repository, $model);
    }
}
