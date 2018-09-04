<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| performer_schedules Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * performer_id INT(10) NOT NULL
| * schedule_id INT(10) NOT NULL
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class PerformerSchedule extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    public $table = 'performer_schedules';
    protected static $bufferAttributeSettings = null;

    public $fillable = [
        'performer_id',
        'schedule_id'
    ];

    public $rules = [
        'performer_id' => 'nullable|integer|exists:performers,id',
        'schedule_id' => 'nullable|integer|exists:schedules,id'
    ];

    public function performer()
    {
        return $this->belongsTo(Performer::class, 'performer_id');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    public function getLabel()
    {
        return "Performer Schedule";
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
            "schedule_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => false,
                "formdisplay" => true,
                "required" => true,
                "relation" => 'schedule',
                "label" => "Schedule",
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
