<?php

namespace App\SuitEvent\Repositories\Contracts;

use App\SuitEvent\Models\Content;

interface ContentRepositoryContract
{
    public function jsonDatatable($param, $columnFormatted);

    public function get($objectId);

    public function create($param, Content &$content);

    public function update($id, $param, Content &$content);

    public function delete($id, Content &$content);
}
