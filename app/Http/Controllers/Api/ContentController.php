<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\Content;
use App\SuitEvent\Repositories\ContentRepository;
use Illuminate\Http\Request;
use Input;
use Response;
use Validator;

class ContentController extends BaseController
{
    protected $defaultParams = [
        'status' => Content::PUBLISHED_STATUS,
        'orderBy' => 'created_at,title',
        'orderType' => 'desc'
    ];

    /**
     * Initialize
     *
     * @param ContentRepository $repository
     * @param Content           $model
     */
    public function __construct(
        ContentRepository $repository,
        Content $model
    ) {
        parent::__construct($repository, $model);
    }
}
