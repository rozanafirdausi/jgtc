<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\City;
use Cache;
use Suitcore\Repositories\SuitRepository;

class CityRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new City;
    }

    public function getCachedList()
    {
        $baseModel = $this->mainModel;
        $list = Cache::rememberForever('city_list', function () use ($baseModel) {
            return $baseModel->get();
        });
        return $list;
    }
}
