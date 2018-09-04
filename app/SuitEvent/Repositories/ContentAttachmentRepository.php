<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\ContentAttachment;
use Cache;
use Suitcore\Repositories\SuitRepository;

class ContentAttachmentRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new ContentAttachment;
    }

    public function getCachedByContent($contentId)
    {
        $lists = [];
        if ($contentId) {
            $baseModel = $this->mainModel;
            $lists = Cache::
            rememberForever('content_attachment_for_content' . $contentId, function () use ($baseModel, $contentId) {
                return $baseModel->where('content_id', $contentId)->orderBy('position_order', 'asc')->get();
            });
        }
        return $lists;
    }
}
