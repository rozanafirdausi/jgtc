<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use Cache;
use DB;
use File;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| banner_images Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * content_id INT(10) UNSIGNED
| * title VARCHAR(255)
| * filename VARCHAR(255)
| * description TEXT
| * position_order INT(11)
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/

class ContentAttachment extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    public $table = 'content_attachments';
    protected static $bufferAttributeSettings = null;

    public $fillable = [
        'content_id',
        'title',
        'filename',
        'description',
        'position_order',
    ];

    public $files = ['filename' => 'content_attachments'];
    public $imageAttributes = ['filename' => 'content_attachments'];

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }

    public function getLabel()
    {
        return "Content Attachment";
    }

    public function getFormattedValue()
    {
        return $this->title;
    }

    public function getFormattedValueColumn()
    {
        return ['title'];
    }

    public function getDefaultOrderColumn()
    {
        return 'position_order';
    }

    public function getDefaultOrderColumnDirection()
    {
        return 'asc';
    }

    public function getAttributeSettings()
    {
        return [
            "id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => false,
                "required" => true,
                "relation" => null,
                "label" => "ID"
            ],
            "content_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => "content",
                "label" => "Content",
                "options" => [], // always initiated
                "readonly" => true,
                "initiated" => true
            ],
            "filename" => [
                "type" => self::TYPE_FILE,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Image File"
            ],
            "title" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Title"
            ],
            "description" => [
                "type" => self::TYPE_TEXTAREA,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Description"
            ],
            "position_order" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Position Order"
            ],
            "created_at" => [
                "type" => self::TYPE_DATETIME,
                "visible" => false,
                "formdisplay" => false,
                "required" => true,
                "relation" => null,
                "label" => "Created At"
            ],
            "updated_at" => [
                "type" => self::TYPE_DATETIME,
                "visible" => false,
                "formdisplay" => false,
                "required" => true,
                "relation" => null,
                "label" => "Updated At"
            ]
        ];
    }

    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            Cache::forever('content_attachment_for_content' . $model->content_id, ContentAttachment::
                where('content_id', $model->content_id)
            ->orderBy('position_order', 'asc')->get());
        });

        static::deleted(function ($model) {
            Cache::forever('content_attachment_for_content' . $model->content_id, ContentAttachment::
                where('content_id', $model->content_id)
            ->orderBy('position_order', 'asc')->get());
        });
    }
}
