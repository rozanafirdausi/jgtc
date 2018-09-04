<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| survey_answers Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * code VARCHAR(64) NOT NULL
| * question_id INT(10) NOT NULL
| * text_type ENUM('numeric', 'float', 'text', 'datetime', 'boolean') NOT NULL
| * text TEXT NOT NULL NOT NULL
| * position_order INT(11) NOT NULL
| * is_visible TINYINT(4) NOT NULL
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class SurveyAnswer extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    public $table = 'survey_answers';
    protected static $bufferAttributeSettings = null;

    // is_visible options
    const STATUS_VISIBLE = 1;
    const STATUS_HIDDEN = 0;

    // text_type options
    const TEXTTYPE_TEXT = "text";
    const TEXTTYPE_NUMERIC = "numeric";
    const TEXTTYPE_FLOAT = "float";
    const TEXTTYPE_BOOLEAN = "boolean";
    const TEXTTYPE_DATETIME = "datetime";
    const TEXTTYPE_DATE = "date";
    const TEXTTYPE_TIME = "time";

    public $fillable = [
        'code',
        'question_id',
        'text_type',
        'text',
        'position_order',
        'is_visible'
    ];

    public $casts = [
        'is_visible' => 'boolean'
    ];

    public $rules = [
        'code' => 'required|string|max:64',
        'question_id' => 'required|integer|exists:survey_questions,id',
        'text_type' => 'required|string|max:64',
        'text' => 'required|string',
        'position_order' => 'required|integer',
        'is_visible' => 'required|integer'
    ];

    public function question()
    {
        return $this->belongsTo(SurveyQuestion::class, 'question_id');
    }

    public function getLabel()
    {
        return "Survey Answer";
    }

    public function getFormattedValue()
    {
        return $this->code . " (Question " . $this->question_id . ")";
    }

    public function getFormattedValueColumn()
    {
        return ['code', 'question_id'];
    }

    public function getDefaultOrderColumn()
    {
        return 'question_id';
    }

    public function getDefaultOrderColumnDirection()
    {
        return 'asc';
    }

    public function getTextTypeOptions()
    {
        return [
            self::TEXTTYPE_TEXT => ucfirst(strtolower(self::TEXTTYPE_TEXT)),
            self::TEXTTYPE_DATETIME => ucfirst(strtolower(self::TEXTTYPE_DATETIME)),
            self::TEXTTYPE_DATE => ucfirst(strtolower(self::TEXTTYPE_DATE)),
            self::TEXTTYPE_TIME => ucfirst(strtolower(self::TEXTTYPE_TIME)),
            self::TEXTTYPE_BOOLEAN => ucfirst(strtolower(self::TEXTTYPE_BOOLEAN)),
            self::TEXTTYPE_FLOAT => ucfirst(strtolower(self::TEXTTYPE_FLOAT)),
            self::TEXTTYPE_NUMERIC => ucfirst(strtolower(self::TEXTTYPE_NUMERIC))
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
            "question_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => 'question',
                "label" => "Question",
                "options" => [],
                "filterable" => true
            ],
            "code" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Code"
            ],
            "text_type" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Text Type",
                "options" => $this->getTextTypeOptions()
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
