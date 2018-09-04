<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\ParticipantAnswer;
use Suitcore\Repositories\SuitRepository;

class ParticipantAnswerRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new ParticipantAnswer;
    }
}
