<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\Participant;
use Suitcore\Repositories\SuitRepository;

class ParticipantRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new Participant;
    }
}
