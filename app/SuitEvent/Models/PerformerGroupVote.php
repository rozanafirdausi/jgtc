<?php

namespace App\SuitEvent\Models;

use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

class PerformerGroupVote extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    public $table = 'performer_group_votes';
    protected static $bufferAttributeSettings = null;

    public $fillable = [
        'performer_group_id',
        'user_id',
        'votes',
        'notes'
    ];

    public $rules = [
        'performer_group_id' => 'required|integer|exists:performer_groups,id',
        'user_id' => 'nullable|integer|exists:users,id',
        'votes' => 'nullable|integer',
        'notes' => 'nullable|string'
    ];

    public function getLabel()
    {
        return "Performer Group Votes";
    }

    public function getFormattedValue()
    {
        return "#" . $this->performer_group_id;
    }

    public function getFormattedValueColumn()
    {
        return ['performer_group_id'];
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
            "performer_group_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Performer Group",
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
