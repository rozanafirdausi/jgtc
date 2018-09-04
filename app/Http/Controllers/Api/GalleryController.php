<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\Gallery;
use App\SuitEvent\Repositories\GalleryRepository;
use Illuminate\Http\Request;
use Input;
use Response;
use Validator;

class GalleryController extends BaseController
{
    protected $defaultParams = [
        'is_visible' => Gallery::STATUS_VISIBLE,
        'orderBy' => 'position_order,title',
        'orderType' => 'asc'
    ];

    /**
     * Initialize
     *
     * @param GalleryRepository $repository
     * @param Gallery           $model
     */
    public function __construct(
        GalleryRepository $repository,
        Gallery $model
    ) {
        parent::__construct($repository, $model);
    }
}
