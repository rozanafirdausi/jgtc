<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use Cache;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| performers Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * name VARCHAR(100) NOT NULL
| * description TEXT
| * avatar VARCHAR(255)
| * job_title VARCHAR(255)
| * institution VARCHAR(255)
| * email VARCHAR(255)
| * average_rate INT(11)
| * position_order INT(11) NOT NULL
| * is_visible TINYINT(4) NOT NULL
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class Performer extends SuitModel
{
    use BlameableTrait;

    // MODEL DEFINITION
    public $table = 'performers';
    protected static $bufferAttributeSettings = null;

    // is_visible options
    const STATUS_VISIBLE = 1;
    const STATUS_HIDDEN = 0;

    // type options
    const TYPE_INTERNATIONAL = 'international';
    const TYPE_NATIONAL = 'national';

    public $fillable = [
        'name',
        'description',
        'type',
        'avatar',
        'mobile_video_url',
        'job_title',
        'institution',
        'email',
        'position_order',
        'is_visible'
    ];

    public $casts = [
        'is_visible' => 'boolean'
    ];

    public $files = ['avatar' => 'performer_avatars'];
    public $imageAttributes = ['avatar' => 'performer_avatars'];

    public $rules = [
        'name' => 'required|string|max:100',
        'description' => 'nullable|string',
        'type' => 'required|string',
        'avatar' => 'nullable|mimes:jpeg,bmp,png',
        'mobile_video_url' => 'nullable|string|max:255',
        'job_title' => 'nullable|string',
        'institution' => 'nullable|string',
        'email' => 'nullable|email',
        'position_order' => 'required|integer',
        'is_visible' => 'required|integer'
    ];

    public function getTypeAttributeLabelAttribute()
    {
        return $this->getTypeOptions()[$this->type];
    }

    public function specifications()
    {
        return $this->hasMany(PerformerSpecification::class, 'performer_id');
    }

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'performer_schedules', 'performer_id', 'schedule_id');
    }

    public function galleries()
    {
        return $this->belongsToMany(Gallery::class, 'performer_galleries', 'performer_id');
    }

    public function getLabel()
    {
        return "Performer";
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

    public function scopeVisibleForType($query, $type)
    {
        return $query->whereNotNull('filename')
                     ->where('type', $type);
    }

    public static function getPerformers($type)
    {
        $performers = Performer::visibleForType($type)
                              ->orderBy('position_order', 'asc')
                              ->get();
        return $performers;
    }

    public function getTypeOptions()
    {
        $default = isset(DefaultConfig::getConfig()['performer_type']) ?
        DefaultConfig::getConfig()['performer_type'] : null;
        if ($default) {
            return $default;
        }
        return [
            self::TYPE_INTERNATIONAL => "International Artist",
            self::TYPE_NATIONAL => "National Artist"
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
            "type" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Performer Type",
                "options" => $this->getTypeOptions()
            ],
            "position_order" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Position Order"
            ],
            "avatar" => [
                "type" => self::TYPE_FILE,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Avatar"
            ],
            "mobile_video_url" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Youtube Video Url (Mobile App)"
            ],
            "job_title" => [
                "type" => self::TYPE_TEXT,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Job Title"
            ],
            "institution" => [
                "type" => self::TYPE_TEXT,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Institution"
            ],
            "email" => [
                "type" => self::TYPE_TEXT,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Email"
            ],
            "average_rate" => [
                "type" => self::TYPE_FLOAT,
                "visible" => true,
                "formdisplay" => $this->id ? true : false,
                "required" => false,
                "readonly" => true,
                "relation" => null,
                "label" => "Average Rate"
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

        static::saved(function () {
            Cache::forget('all_visible_performer_orderby_position');
        });

        static::deleted(function () {
            Cache::forget('all_visible_performer_orderby_position');
        });
    }
}
