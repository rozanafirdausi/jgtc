<?php

namespace App\SuitEvent\Models;

use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| performer_candidate_votes Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * candidate_id INT(10) UNSIGNED NOT NULL
| * user_id INT(10) UNSIGNED
| * votes INT(11)
| * notes TEXT
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class PerformerCandidateVote extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    public $table = 'performer_candidate_votes';
    protected static $bufferAttributeSettings = null;

    public $fillable = [
        'candidate_id',
        'user_id',
        'votes',
        'notes'
    ];

    public $rules = [
        'candidate_id' => 'required|integer|exists:performer_candidates,id',
        'user_id' => 'nullable|integer|exists:users,id',
        'votes' => 'nullable|integer',
        'notes' => 'nullable|string'
    ];

    public function getLabel()
    {
        return "Performer Candidate Votes";
    }

    public function getFormattedValue()
    {
        return "#" . $this->candidate_id;
    }

    public function getFormattedValueColumn()
    {
        return ['candidate_id'];
    }

    public function getDefaultOrderColumn()
    {
        return 'created_at';
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
            "candidate_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Performer Candidate",
                "options" => []
            ],
            "user_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "User",
                "options" => []
            ],
            "votes" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Votes"
            ],
            "notes" => [
                "type" => self::TYPE_TEXTAREA,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Notes"
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
