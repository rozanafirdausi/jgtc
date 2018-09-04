<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use Cache;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| sponsors Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * type VARCHAR(64) NOT NULL
| * name VARCHAR(100) NOT NULL
| * description TEXT
| * logo VARCHAR(255)
| * logo_orientation VARCHAR(255)
| * url VARCHAR(255)
| * position_order INT(11) NOT NULL
| * is_visible TINYINT(4) NOT NULL
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class Sponsor extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    public $table = 'sponsors';
    protected static $bufferAttributeSettings = null;

    // type options
    const TYPE_ORGANIZER = 'organizer';
    const TYPE_SUPPORTER = 'supporter';
    const TYPE_MEDIA = 'media';
    const TYPE_OFFICIAL_TICKETING = 'official-ticketing';

    // logo_orientation options
    const LOGO_PORTRAIT = 'portrait';
    const LOGO_LANDSCAPE = 'landscape';

     // is_visible options
    const STATUS_VISIBLE = 1;
    const STATUS_HIDDEN = 0;

    public $fillable = [
        'type',
        'name',
        'description',
        'logo',
        'logo_orientation',
        'url',
        'position_order',
        'is_visible'
    ];

    public $casts = [
        'is_visible' => 'boolean'
    ];

    public $files = ['logo' => 'sponsors_logos'];
    public $imageAttributes = ['logo' => 'sponsors_logos'];

    public $rules = [
        'type' => 'required|string|max:64',
        'name' => 'required|string|max:100',
        'description' => 'nullable|string',
        'logo' => 'nullable|mimes:jpeg,bmp,png',
        'logo_orientation' => 'nullable|string|max:255',
        'url' => 'nullable|string|max:255',
        'position_order' => 'required|integer',
        'is_visible' => 'required|integer'
    ];

    public function getLabel()
    {
        return "Sponsor";
    }

    public function getFormattedValue()
    {
        return $this->name . " " . ($this->type);
    }

    public function getFormattedValueColumn()
    {
        return ['name', 'type'];
    }

    public function getDefaultOrderColumn()
    {
        return 'type';
    }

    public function getDefaultOrderColumnDirection()
    {
        return 'asc';
    }

    public function getTypeOptions()
    {
        $default = isset(DefaultConfig::getConfig()['sponsor_type']) ?
        DefaultConfig::getConfig()['sponsor_type'] : null;
        if ($default) {
            return $default;
        }
        return [
            self::TYPE_ORGANIZER => "Organizer",
            self::TYPE_SUPPORTER => "Supporter",
            self::TYPE_MEDIA => "Media",
            self::TYPE_OFFICIAL_TICKETING => "Official Ticketing Partner"
        ];
    }

    public function getLogoOrientationOptions()
    {
        return [
            self::LOGO_PORTRAIT => "Portrait",
            self::LOGO_LANDSCAPE => "Landscape"
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
            "type" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Type",
                "options" => $this->getTypeOptions(),
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
            "logo" => [
                "type" => self::TYPE_FILE,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Logo"
            ],
            "logo_orientation" => [
                "type" => self::TYPE_TEXT,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "readonly" => false,
                "relation" => null,
                "label" => "Logo Orientation",
                "options" => $this->getLogoOrientationOptions()
            ],
            "url" => [
                "type" => self::TYPE_TEXT,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "readonly" => false,
                "relation" => null,
                "label" => "URL"
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
            Cache::forget('all_sponsor_type_' . $model->type);
        });

        static::deleted(function ($model) {
            Cache::forget('all_sponsor_type_' . $model->type);
        });
    }
}
