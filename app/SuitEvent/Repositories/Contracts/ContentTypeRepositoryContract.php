<?php

namespace App\SuitEvent\Repositories\Contracts;

use App\SuitEvent\Models\ContentType;

interface ContentTypeRepositoryContract
{
    public function jsonDatatable($param, $columnFormatted);

    public function get($objectId);

    public function create($param, ContentType &$contentType);

    public function update($id, $param, ContentType &$contentType);

    public function delete($id, ContentType &$contentType);
}
