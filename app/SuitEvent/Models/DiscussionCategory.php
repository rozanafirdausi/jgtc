<?php

namespace App\SuitEvent\Models;

use Cache;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

class DiscussionCategory extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION

    public $table = 'discussion_categories';
    protected static $bufferAttributeSettings = null;

    public $fillable = [
        'name'
    ];

    public $rules = [
        'name' => 'required'
    ];

    // RELATIONSHIP
    /**
     * Get categories of the discussion.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }

    public function getLabel()
    {
        return 'Discussion Category';
    }

    public function getFormattedValue()
    {
        return $this->name;
    }

    public function getOptions()
    {
        return self::all();
    }

    public function getDefaultOrderColumn()
    {
        return 'id';
    }

    public function getDefaultOrderColumnDirection()
    {
        return 'asc';
    }

    public function getAttributeSettings()
    {
        // default attribute settings of generic model, override for furher use
        // default attribute settings of generic model, override for furher use
        return [
            'id' => [
                'type' => self::TYPE_NUMERIC,
                'visible' => true,
                'formdisplay' => false,
                'required' => true,
                'relation' => null,
                'label' => 'ID'
            ],
            'name' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Name'
            ],
            'created_at' => [
                'type' => self::TYPE_DATETIME,
                'visible' => true,
                'formdisplay' => false,
                'required' => false,
                'relation' => null,
                'label' => 'Created At'
            ],
            'updated_at' => [
                'type' => self::TYPE_DATETIME,
                'visible' => true,
                'formdisplay' => false,
                'required' => false,
                'relation' => null,
                'label' => 'Updated At'
            ]
        ];
    }
}
