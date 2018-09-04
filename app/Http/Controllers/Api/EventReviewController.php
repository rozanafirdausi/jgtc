<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\EventReview;
use App\SuitEvent\Repositories\EventReviewRepository;
use Illuminate\Http\Request;
use Input;
use Response;
use Validator;

class EventReviewController extends BaseController
{
    protected $defaultParams = [
        'orderBy' => 'created_at',
        'orderType' => 'desc'
    ];

    /**
     * Initialize
     *
     * @param EventReviewRepository $repository
     * @param EventReview           $model
     */
    public function __construct(
        EventReviewRepository $repository,
        EventReview $model
    ) {
        parent::__construct($repository, $model);
    }

    protected function postCreate()
    {
        $param = Input::all();
        $param['is_visible'] = 0;
        $param['is_featured'] = 0;
        $baseObj = $this->baseModel;

        if ($result = $this->repository->create($param, $baseObj)) {
            return $this->toJson(200, [
                'message' => 'Data ' . $baseObj->getLabel() . ' has been created!',
                'result' => $result,
            ]);
        }
        return $this->toJson(500, [
            'message' => 'Error when creating ' . $baseObj->getLabel() . ' data!',
            'result' => $baseObj->errors,
            'param' => $param
        ]);
    }
}
