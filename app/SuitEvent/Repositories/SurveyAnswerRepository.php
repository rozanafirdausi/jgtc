<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\SurveyAnswer;
use Suitcore\Repositories\SuitRepository;

class SurveyAnswerRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new SurveyAnswer;
    }
}
