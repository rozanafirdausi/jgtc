<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\BannerImage;
use Cache;
use Suitcore\Repositories\SuitRepository;

class BannerImageRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new BannerImage;
    }

    public function getCachedList($positionCode)
    {
        $bannerList = [];
        if ($positionCode) {
            $baseModel = $this->mainModel;
            $bannerList = Cache::
            rememberForever('banner_for_type_' . $positionCode, function () use ($baseModel, $positionCode) {
                return $baseModel->visibleForType($positionCode)->get();
            });
        }
        return $bannerList;
    }
}
