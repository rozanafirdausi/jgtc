<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Models\PerformerCandidate;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

class PerformerGroup extends SuitModel
{
    use BlameableTrait;

    public $table = 'performer_groups';
    protected static $bufferAttributeSettings = null;

    public $fillable = [
        'performer_1_id',
        'performer_2_id',
        'total_vote'
    ];

    public $rules = [
        'performer_1_id' => 'required|exists:performers,id',
        'performer_2_id' => 'required|exists:performers,id'
    ];

    public function performer1()
    {
        return $this->belongsTo(PerformerCandidate::class, 'performer_1_id');
    }

    public function performer2()
    {
        return $this->belongsTo(PerformerCandidate::class, 'performer_2_id');
    }

    public function getLabel()
    {
        return "Performer Group";
    }

    public function getFormattedValue()
    {
        return "#" . $this->id;
    }

    public function getFormattedValueColumn()
    {
        return ['id'];
    }

    public function getOptions()
    {
        return self::all();
    }

    public function getDefaultOrderColumn()
    {
        return 'created_at';
    }

    public function getDefaultOrderColumnDirection()
    {
        return 'desc';
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
            "performer_1_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => "performer1",
                "label" => "Main Performer",
                "options" => [], // always initiated
                "readonly" => true,
                "initiated" => true,
                "filterable" => true
            ],
            "performer_2_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => "performer2",
                "label" => "Support Performer",
                "options" => [], // Access using select2
            ],
            "total_vote" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "readonly" => true,
                "relation" => null,
                "label" => "Total Vote"
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
