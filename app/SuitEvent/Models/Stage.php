<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use Cache;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| stages Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * name VARCHAR(100) NOT NULL
| * description TEXT
| * image VARCHAR(255)
| * position_order INT(11) NOT NULL
| * is_visible TINYINT(4) NOT NULL
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class Stage extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    public $table = 'stages';
    protected static $bufferAttributeSettings = null;

    // event type options
    const TYPE_PRE = 'pre';
    const TYPE_EVENT = 'event';
    const TYPE_POST = 'post';

    // is_visible options
    const STATUS_VISIBLE = 1;
    const STATUS_HIDDEN = 0;

    public $fillable = [
        'event_type',
        'name',
        'description',
        'image',
        'mc',
        'position_order',
        'is_visible'
    ];

    public $casts = [
        'is_visible' => 'boolean'
    ];

    public $files = ['image' => 'stage_images'];
    public $imageAttributes = ['image' => 'stage_images'];

    public $rules = [
        'name' => 'required|string|max:100',
        'description' => 'nullable|string',
        'image' => 'nullable|mimes:jpeg,bmp,png',
        'position_order' => 'required|integer',
        'is_visible' => 'required|integer'
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'stage_id');
    }

    public function getLabel()
    {
        return "Stage";
    }

    public function getFormattedValue()
    {
        return $this->name;
    }

    public function getFormattedValueColumn()
    {
        return ['name'];
    }

    public function getDefaultOrderColumn()
    {
        return 'position_order';
    }

    public function getDefaultOrderColumnDirection()
    {
        return 'asc';
    }

    public function getStatusOptions()
    {
        return [
            self::STATUS_VISIBLE => "Visible",
            self::STATUS_HIDDEN => "Hidden"
        ];
    }

    public function getEventTypeOptions()
    {
        $default = isset(DefaultConfig::getConfig()['schedule_event_type']) ?
        DefaultConfig::getConfig()['schedule_event_type'] : null;
        if ($default) {
            return $default;
        }
        return [
            self::TYPE_PRE => 'Pre-Event',
            self::TYPE_EVENT => 'Event',
            self::TYPE_POST => 'Post-Event'
        ];
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
            "event_type" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Event Type",
                "options" => $this->getEventTypeOptions(),
                "filterable" => true
            ],
            "name" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Name"
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
                "required" => true,
                "relation" => null,
                "label" => "Position Order"
            ],
            "image" => [
                "type" => self::TYPE_FILE,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "image"
            ],
            "mc" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "MC"
            ],
            "is_visible" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Status",
                "options" => $this->getStatusOptions(),
                "filterable" => true
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

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            Cache::forget('main-schedule-day-1');
            Cache::forget('main-schedule-day-2');
        });

        static::deleted(function ($model) {
            Cache::forget('main-schedule-day-1');
            Cache::forget('main-schedule-day-2');
        });
    }
}
