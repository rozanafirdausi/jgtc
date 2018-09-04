<?php

namespace App\SuitEvent\Repositories\Contracts;

use App\SuitEvent\Models\BannerImage;

interface BannerImageRepositoryContract
{
    public function jsonDatatable($param, $columnFormatted);

    public function get($objectId);

    public function create($param, BannerImage &$bannerImage);

    public function update($id, $param, BannerImage &$bannerImage);

    public function delete($id, BannerImage &$bannerImage);
}
