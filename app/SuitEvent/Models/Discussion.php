<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Models\DiscussionCategory;
use App\SuitEvent\Models\Participant;
use App\SuitEvent\Models\User;
use Cache;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

class Discussion extends SuitModel
{
    use BlameableTrait;
    // MODEL DEFINITION

    public $table = 'discussions';
    protected static $bufferAttributeSettings = null;

    public $fillable = [
        'name',
        'message',
        'category_id',
        'user_id',
        'participant_id'
    ];

    public $rules = [
        'name' => 'required',
        'message' => 'required',
        'category_id' => 'required|exists:discussion_categories,id'
    ];

    // RELATIONSHIP
    /**
     * Get the category of the discussion.
     * @return \App\SuitEvent\Models\DiscussionCategory|null
     */
    public function discussionCategory()
    {
        return $this->belongsTo(DiscussionCategory::class, 'category_id');
    }

    public function sender1()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sender2()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }
    
    public function getDefaultOrderColumn()
    {
        return 'created_at';
    }

    public function getDefaultOrderColumnDirection()
    {
        return 'desc';
    }

    public function getAttributeSettings()
    {
        // default attribute settings of generic model, override for furher use
        return [
            "id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => false,
                "required" => true,
                "relation" => null,
                "label" => "ID"
            ],
            "message" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Message"
            ],
            "category_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => "discussionCategory",
                "label" => "Discussion Category",
                "options" => (new DiscussionCategory)->all()->pluck('name', 'id'),
            ],
            "created_at" => [
                "type" => self::TYPE_DATETIME,
                "visible" => true,
                "formdisplay" => false,
                "required" => false,
                "relation" => null,
                "label" => "Created At"
            ],
            "updated_at" => [
                "type" => self::TYPE_DATETIME,
                "visible" => true,
                "formdisplay" => false,
                "required" => false,
                "relation" => null,
                "label" => "Updated At"
            ]
        ];
    }
}
