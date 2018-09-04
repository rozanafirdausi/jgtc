<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\ContentCategory;
use Cache;
use Suitcore\Repositories\SuitRepository;

class ContentCategoryRepository extends SuitRepository
{
    protected $contentTypeRepo;

    public function __construct(ContentTypeRepository $_contentTypeRepo)
    {
        $this->mainModel = new ContentCategory;
        $this->contentTypeRepo = $_contentTypeRepo;
    }

    public function getOrInit($slug, $typeCode)
    {
        $relatedType = $this->contentTypeRepo->getOrInit($typeCode);
        $currentState = $this->getBy($slug, $typeCode);
        if (!$currentState) {
            $currentState = new ContentCategory;
            $currentState->parent_id = null;
            $currentState->type_id = $relatedType->id;
            $currentState->name = ucfirst(strtolower($slug));
            $currentState->slug = $slug;
            $currentState->save();
        }
        return $currentState;
    }

    public function getBy($slug, $typeCode)
    {
        $currentState = $this->getCachedList($typeCode);
        return (isset($currentState[$slug]) ? $currentState[$slug] : null);
    }

    public function getCachedList($typeCode)
    {
        $relatedType = $this->contentTypeRepo->getBy($typeCode);
        $contentCategoryList = [];
        if ($relatedType) {
            $baseModel = $this->mainModel;
            $contentCategoryList = Cache::rememberForever(
                'content_category_for_type_' . $relatedType->code,
                function () use ($baseModel, $relatedType) {
                    return $baseModel->where('type_id', '=', $relatedType->id)->get()->keyBy('slug');
                }
            );
        }
        return $contentCategoryList;
    }
}
