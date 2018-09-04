<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| survey_questions Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * type VARCHAR(64) NOT NULL
| * code VARCHAR(64) NOT NULL
| * text TEXT NOT NULL NOT NULL
| * position_order INT(11) NOT NULL
| * is_visible TINYINT(4) NOT NULL
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class SurveyQuestion extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    public $table = 'survey_questions';
    protected static $bufferAttributeSettings = null;

    // is_visible options
    const STATUS_VISIBLE = 1;
    const STATUS_HIDDEN = 0;

    // type options
    const TYPE_VOLUNTEER = 'volunteer';
    const TYPE_ATTENDEE = 'attendee';
    const TYPE_COMMITTEE = 'committee';

    public $fillable = [
        'type',
        'code',
        'text',
        'position_order',
        'is_visible'
    ];

    public $casts = [
        'is_visible' => 'boolean'
    ];

    public $rules = [
        'type' => 'required|string|max:64',
        'code' => 'required|string|max:64',
        'text' => 'required|string',
        'position_order' => 'required|integer',
        'is_visible' => 'required|integer'
    ];

    public function getLabel()
    {
        return "Survey Question";
    }

    public function getFormattedValue()
    {
        return $this->code . " (" . $this->type . ")";
    }

    public function getFormattedValueColumn()
    {
        return ['code', 'type'];
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
        $default = isset(DefaultConfig::getConfig()['survey_question_type']) ?
        DefaultConfig::getConfig()['survey_question_type'] : null;
        if ($default) {
            return $default;
        }
        return [
            self::TYPE_VOLUNTEER => "Volunteer",
            self::TYPE_ATTENDEE => "Attendee",
            self::TYPE_COMMITTEE => "Committee"
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
            "code" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "readonly" => $this->id ? true : false,
                "relation" => null,
                "label" => "Code"
            ],
            "text" => [
                "type" => self::TYPE_TEXTAREA,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Text"
            ],
            "position_order" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
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
                "options" => $this->getStatusOptions()
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
