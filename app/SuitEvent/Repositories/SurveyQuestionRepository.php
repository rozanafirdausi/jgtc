<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\SurveyQuestion;
use Suitcore\Repositories\SuitRepository;

class SurveyQuestionRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new SurveyQuestion;
    }
}
