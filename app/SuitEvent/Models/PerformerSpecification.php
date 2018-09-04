<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| performers Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * performer_id INT(10) UNSIGNED NOT NULL
| * type VARCHAR(255) NOT NULL
| * key VARCHAR(255) NOT NULL
| * value VARCHAR(255)
| * description TEXT
| * position_order INT(10) NOT NULL
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class PerformerSpecification extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    public $table = 'performer_specifications';
    protected static $bufferAttributeSettings = null;

    // specification type options
    const TYPE_SOCIAL = 'social';

    // specification key options
    const KEY_SOCIAL_FACEBOOK = 'facebook';
    const KEY_SOCIAL_TWITTER = 'twitter';
    const KEY_SOCIAL_INSTAGRAM = 'instagram';
    const KEY_SOCIAL_GOOGLE = 'google';
    const KEY_SOCIAL_YOUTUBE = 'youtube';

    public $fillable = [
        'performer_id',
        'type',
        'key',
        'value',
        'description',
        'position_order'
    ];

    public $rules = [
        'performer_id' => 'required|exists:performers,id',
        'type' => 'required|string',
        'key' => 'required|string',
        'value' => 'nullable|string',
        'description' => 'nullable|string',
        'position_order' => 'required|integer'
    ];

    public function performer()
    {
        return $this->belongsTo(Performer::class, 'performer_id');
    }

    public function getLabel()
    {
        return "Performer Specification";
    }

    public function getFormattedValue()
    {
        return $this->key;
    }

    public function getFormattedValueColumn()
    {
        return ['key'];
    }

    public function getDefaultOrderColumn()
    {
        return 'position_order';
    }

    public function getDefaultOrderColumnDirection()
    {
        return 'asc';
    }

    public function getTypeOptions()
    {
        $default = isset(DefaultConfig::getConfig()['performer_specification_type']) ?
        DefaultConfig::getConfig()['performer_specification_type'] : null;
        if ($default) {
            return $default;
        }
        return [
            self::TYPE_SOCIAL => 'Social Link'
        ];
    }

    public function getKeyOptions()
    {
        $default = isset(DefaultConfig::getConfig()['performer_specification_key']) ?
        DefaultConfig::getConfig()['performer_specification_key'] : null;
        if ($default) {
            return $default;
        }
        return [
            self::KEY_SOCIAL_FACEBOOK => 'Facebook',
            self::KEY_SOCIAL_TWITTER => 'Twitter',
            self::KEY_SOCIAL_INSTAGRAM => 'Instagram',
            self::KEY_SOCIAL_GOOGLE => 'Google',
            self::KEY_SOCIAL_YOUTUBE => 'Youtube'
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
            "performer_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => 'performer',
                "label" => "Performer",
                "readonly" => true,
                "options" => []
            ],
            "type" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Type",
                "options" => $this->getTypeOptions()
            ],
            "position_order" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Position Order"
            ],
            "key" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Key",
                "options" => $this->getKeyOptions()
            ],
            "value" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Value"
            ],
            "description" => [
                "type" => self::TYPE_TEXTAREA,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Description"
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
