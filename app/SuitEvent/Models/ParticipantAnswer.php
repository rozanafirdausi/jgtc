<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use App\SuitEvent\Models\User;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| participant_answers Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * participant_id INT(10) NOT NULL
| * user_id INT(10) NOT NULL
| * question_id INT(10) NOT NULL
| * answer_id INT(10) NOT NULL
| * text_type ENUM('numeric', 'float', 'text', 'datetime', 'boolean') NOT NULL
| * text TEXT NOT NULL NOT NULL
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class ParticipantAnswer extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    public $table = 'participant_answers';
    protected static $bufferAttributeSettings = null;

    // text_type options
    const TEXTTYPE_TEXT = "text";
    const TEXTTYPE_NUMERIC = "numeric";
    const TEXTTYPE_FLOAT = "float";
    const TEXTTYPE_BOOLEAN = "boolean";
    const TEXTTYPE_DATETIME = "datetime";
    const TEXTTYPE_DATE = "date";
    const TEXTTYPE_TIME = "time";

    public $fillable = [
        'participant_id',
        'user_id',
        'question_id',
        'answer_id',
        'text_type',
        'text'
    ];

    public $rules = [
        'participant_id' => 'nullable|integer|exists:participants,id',
        'user_id' => 'nullable|integer|exists:users,id',
        'question_id' => 'required|integer|exists:survey_questions,id',
        'answer_id' => 'nullable|integer|exists:survey_answers,id',
        'text_type' => 'nullable|string|max:64',
        'text' => 'nullable|string'
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function question()
    {
        return $this->belongsTo(SurveyQuestion::class, 'question_id');
    }

    public function answer()
    {
        return $this->belongsTo(SurveyAnswer::class, 'answer_id');
    }

    public function getLabel()
    {
        return "Participant Answer";
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
            "participant_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => 'participant',
                "label" => "Participant",
                "options" => []
            ],
            "user_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => false,
                "formdisplay" => true,
                "required" => true,
                "relation" => 'user',
                "label" => "User",
                "options" => []
            ],
            "question_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => 'question',
                "label" => "Question",
                "options" => []
            ],
            "answer_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => false,
                "formdisplay" => true,
                "required" => true,
                "relation" => 'answer',
                "label" => "Multiple Choice Answer",
                "options" => []
            ],
            "text_type" => [
                "type" => self::TYPE_TEXT,
                "visible" => false,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Free Text Answer (Type)",
                "options" => $this->getTextTypeOptions()
            ],
            "text" => [
                "type" => self::TYPE_TEXTAREA,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Free Text Answer (Value)"
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
