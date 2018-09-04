<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

class PerformerGallery extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    public $table = 'performer_galleries';
    protected static $bufferAttributeSettings = null;

    public $fillable = [
        'performer_id',
        'gallery_id'
    ];

    public $rules = [
        'performer_id' => 'nullable|integer|exists:performers,id',
        'gallery_id' => 'nullable|integer|exists:galleries,id'
    ];

    public function performer()
    {
        return $this->belongsTo(Performer::class, 'performer_id');
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id');
    }

    public function getLabel()
    {
        return "Performer Gallery";
    }

    public function getFormattedValue()
    {
        return '#' . $this->id;
    }

    public function getFormattedValueColumn()
    {
        return ['id'];
    }

    public function getDefaultOrderColumn()
    {
        return 'id';
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
                "visible" => false,
                "formdisplay" => false,
                "required" => true,
                "relation" => null,
                "label" => "ID"
            ],
            "gallery_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => false,
                "formdisplay" => true,
                "required" => true,
                "relation" => 'gallery',
                "label" => "Gallery",
                "readonly" => true,
                "options" => []
            ],
            "performer_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => 'performer',
                "label" => "Performer",
                "options" => []
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
                "visible" => true,
                "formdisplay" => false,
                "required" => true,
                "relation" => null,
                "label" => "Updated At"
            ]
        ];
    }
}
