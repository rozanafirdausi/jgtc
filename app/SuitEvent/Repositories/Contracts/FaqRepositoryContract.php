<?php

namespace App\SuitEvent\Repositories\Contracts;

use App\SuitEvent\Models\Faq;

interface FaqRepositoryContract
{
    public function jsonDatatable($param, $columnFormatted);

    public function get($objectId);

    public function create($param, Faq &$faq);

    public function update($id, $param, Faq &$faq);

    public function delete($id, Faq &$faq);
}
