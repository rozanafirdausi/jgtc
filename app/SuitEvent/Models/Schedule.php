<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use Cache;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| schedules Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * event_type VARCHAR(255)
| * title VARCHAR(255) NOT NULL
| * description TEXT
| * image VARCHAR(255)
| * banner VARCHAR(255)
| * stage_id INT(10) UNSIGNED NOT NULL
| * location VARCHAR(255)
| * start_date DATETIME NOT NULL
| * end_date DATETIME NOT NULL
| * total_rate INT(11)
| * max_participant INT(11)
| * num_participant INT(11)
| * position_order INT(11) NOT NULL
| * is_visible TINYINT(4) NOT NULL
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class Schedule extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    public $table = 'schedules';
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
        'title',
        'description',
        'image',
        'banner',
        'stage_id',
        'location',
        'start_date',
        'end_date',
        'max_participant',
        'position_order',
        'is_visible'
    ];

    public $casts = [
        'is_visible' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public $files = [
        'image' => 'schedule_images',
        'banner' => 'schedule_banners'
    ];
    public $imageAttributes = [
        'image' => 'schedule_images',
        'banner' => 'schedule_banners'
    ];

    public $rules = [
        'event_type' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|mimes:jpeg,bmp,png',
        'banner' => 'nullable|mimes:jpeg,bmp,png',
        'stage_id' => 'nullable|exists:stages,id',
        'location' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'max_participant' => 'nullable|integer',
        'position_order' => 'nullable|integer',
        'is_visible' => 'required|integer'
    ];

    public function stage()
    {
        return $this->belongsTo(Stage::class, 'stage_id');
    }

    public function performers()
    {
        return $this->belongsToMany(Performer::class, 'performer_schedules', 'schedule_id');
    }

    public function getLabel()
    {
        return "Schedule";
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
        return 'start_date';
    }

    public function getDefaultOrderColumnDirection()
    {
        return 'asc';
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

    public function getStatusOptions()
    {
        return [
            self::STATUS_VISIBLE => "Visible",
            self::STATUS_HIDDEN => "Hidden"
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
            "start_date" => [
                "type" => self::TYPE_DATETIME,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Start Date",
            ],
            "end_date" => [
                "type" => self::TYPE_DATETIME,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "End Date"
            ],
            "image" => [
                "type" => self::TYPE_FILE,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Image"
            ],
            "banner" => [
                "type" => self::TYPE_FILE,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Banner"
            ],
            "stage_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => 'stage',
                "label" => "Stage/ Area",
                "options" => [],
            ],
            "location" => [
                "type" => self::TYPE_TEXT,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Location"
            ],
            "total_rate" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => false,
                "formdisplay" => $this->id ? true : false,
                "required" => false,
                "readonly" => true,
                "relation" => null,
                "label" => "Total Rate"
            ],
            "max_participant" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => false,
                "formdisplay" => $this->id ? true : false,
                "required" => false,
                "readonly" => true,
                "relation" => null,
                "label" => "Max of Participant"
            ],
            "num_participant" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => false,
                "formdisplay" => $this->id ? true : false,
                "required" => false,
                "readonly" => true,
                "relation" => null,
                "label" => "Num of Participant"
            ],
            "position_order" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => false,
                "formdisplay" => false,
                "required" => true,
                "relation" => null,
                "label" => "Position Order"
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
            if ($model->event_type == 'rts') {
                Cache::forget('upcoming_roadshow_schedule');
                Cache::forget('latest_roadshow_schedule');
            } elseif ($model->event_type == self::TYPE_EVENT) {
                Cache::forget('main-schedule-day-1');
                Cache::forget('main-schedule-day-2');
            }
        });

        static::deleted(function ($model) {
            if ($model->event_type == 'rts') {
                Cache::forget('upcoming_roadshow_schedule');
                Cache::forget('latest_roadshow_schedule');
            } elseif ($model->event_type == self::TYPE_EVENT) {
                Cache::forget('main-schedule-day-1');
                Cache::forget('main-schedule-day-2');
            }
        });
    }
}
