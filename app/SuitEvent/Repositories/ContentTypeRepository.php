<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\ContentType;
use Cache;
use Suitcore\Repositories\SuitRepository;

class ContentTypeRepository extends SuitRepository
{
    // ATTRIBUTES

    // METHODS
    public function __construct()
    {
        $this->mainModel = new ContentType;
    }

    public function getOrInit($code)
    {
        $currentState = $this->getBy($code);
        if (!$currentState) {
            $currentState = new ContentType;
            $currentState->name = ucfirst(strtolower($code));
            $currentState->code = $code;
            $currentState->save();
        }
        return $currentState;
    }

    public function getBy($code)
    {
        $currentState = $this->getCachedList();
        return (isset($currentState[$code]) ? $currentState[$code] : null);
    }

    public function getCachedList()
    {
        $baseModel = $this->mainModel;
        $contentTypeList = Cache::rememberForever('content_type_by_code', function () use ($baseModel) {
            return $baseModel->all()->keyBy('code');
        });
        return $contentTypeList;
    }
}
