<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| event_reviews Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * user_id INT(10) UNSIGNED
| * name VARCHAR(255)
| * stars INT(11)
| * text TEXT
| * is_featured TINYINT(4) NOT NULL
| * is_visible TINYINT(4) NOT NULL
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class EventReview extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    public $table = 'event_reviews';
    protected static $bufferAttributeSettings = null;

    // is_visible options
    const STATUS_VISIBLE = 1;
    const STATUS_HIDDEN = 0;

    public $fillable = [
        'user_id',
        'name',
        'stars',
        'text',
        'is_featured',
        'is_visible'
    ];

    public $casts = [
        'is_featured' => 'boolean',
        'is_visible' => 'boolean'
    ];

    public $rules = [
        'user_id' => 'nullable|exists:users,id',
        'name' => 'nullable|string|max:255',
        'stars' => 'nullable|integer',
        'text' => 'nullable|string',
        'is_featured' => 'nullable|integer',
        'is_visible' => 'nullable|integer'
    ];

    public function getLabel()
    {
        return "Event Review";
    }

    public function getFormattedValue()
    {
        return "#" . $this->id . " from " . $this->name;
    }

    public function getFormattedValueColumn()
    {
        return ['id'];
    }

    public function getDefaultOrderColumn()
    {
        return 'created_at';
    }

    public function getDefaultOrderColumnDirection()
    {
        return 'desc';
    }

    public function getFeaturedOptions()
    {
        return [
            0 => 'No',
            1 => 'Yes'
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
            "name" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Name"
            ],
            "stars" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Star"
            ],
            "text" => [
                "type" => self::TYPE_TEXTAREA,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Text"
            ],
            "is_featured" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Featured",
                "options" => $this->getFeaturedOptions(),
                "filterable" => true
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
}
