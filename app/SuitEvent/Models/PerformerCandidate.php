<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| performer_candidates Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * type VARCHAR(64) NOT NULL
| * collab_type VARCHAR(64)
| * name VARCHAR(100) NOT NULL
| * description TEXT
| * avatar VARCHAR(255)
| * position_order INT(11) NOT NULL
| * total_vote INT(11)
| * is_visible TINYINT(4) NOT NULL
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class PerformerCandidate extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    public $table = 'performer_candidates';
    protected static $bufferAttributeSettings = null;

    // type options
    const TYPE_SOLO = 'solo';
    const TYPE_GROUP = 'group';

    // is_visible options
    const STATUS_VISIBLE = 1;
    const STATUS_HIDDEN = 0;

    public $fillable = [
        'type',
        'collab_type',
        'name',
        'description',
        'avatar',
        'position_order',
        'is_visible'
    ];

    public $casts = [
        'is_visible' => 'boolean'
    ];

    public $files = ['avatar' => 'performer_candidate_avatars'];
    public $imageAttributes = ['avatar' => 'performer_candidate_avatars'];

    public $rules = [
        'type' => 'required|string|max:64',
        'name' => 'required|string|max:100',
        'description' => 'nullable|string',
        'avatar' => 'nullable|mimes:jpeg,bmp,png',
        'position_order' => 'required|integer',
        'is_visible' => 'required|integer'
    ];

    public function getLabel()
    {
        return "Performer Candidate";
    }

    public function getFormattedValue()
    {
        return $this->name;
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

    public function getStatusOptions()
    {
        return [
            self::STATUS_VISIBLE => "Visible",
            self::STATUS_HIDDEN => "Hidden"
        ];
    }

    public function getTypeOptions()
    {
        $default = isset(DefaultConfig::getConfig()['performer_candidate_type']) ? DefaultConfig::
            getConfig()['performer_candidate_type'] : null;
        if ($default) {
            return $default;
        }
        return [
            self::TYPE_SOLO => "Solo",
            self::TYPE_GROUP => "Group"
        ];
    }

    public function getCollabTypeOptions()
    {
        return [
            'main' => "Main Collaborator",
            'support' => "Support Collaborator"
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
            "collab_type" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Collaboration Type",
                "options" => $this->getCollabTypeOptions()
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
                "formdisplay" => false,
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
            "avatar" => [
                "type" => self::TYPE_FILE,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Avatar"
            ],
            "total_vote" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => $this->id ? true : false,
                "required" => false,
                "readonly" => true,
                "relation" => null,
                "label" => "Total Votes"
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
