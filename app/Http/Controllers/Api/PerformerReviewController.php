<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\Performer;
use App\SuitEvent\Models\PerformerReview;
use App\SuitEvent\Repositories\PerformerReviewRepository;
use Illuminate\Http\Request;
use Input;
use Response;
use Validator;

class PerformerReviewController extends BaseController
{
    protected $defaultParams = [
        'orderBy' => 'created_at',
        'orderType' => 'desc'
    ];

    /**
     * Initialize
     *
     * @param PerformerReviewRepository $repository
     * @param PerformerReview           $model
     */
    public function __construct(
        PerformerReviewRepository $repository,
        PerformerReview $model
    ) {
        parent::__construct($repository, $model);
    }

    protected function postCreate()
    {
        $param = Input::all();
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
