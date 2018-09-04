<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use Cache;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| galleries Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * type VARCHAR(64) NOT NULL
| * title VARCHAR(255) NOT NULL
| * description TEXT
| * url VARCHAR(255)
| * content VARCHAR(255)
| * position_order INT(11) NOT NULL
| * is_visible TINYINT(4) NOT NULL
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class Gallery extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    public $table = 'galleries';
    protected static $bufferAttributeSettings = null;

    // type options
    const TYPE_IMAGE = 'image';
    const TYPE_VIDEO = 'video';

    // is_visible options
    const STATUS_VISIBLE = 1;
    const STATUS_HIDDEN = 0;

    public $fillable = [
        'type',
        'title',
        'description',
        'url',
        'content',
        'position_order',
        'is_visible'
    ];

    public $casts = [
        'is_visible' => 'boolean'
    ];

    public $files = ['content' => 'gallery_contents'];
    public $imageAttributes = ['content' => 'gallery_contents'];

    public $rules = [
        'type' => 'required|string|max:64',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'url' => 'nullable|string|max:255',
        'content' => 'nullable|mimes:jpeg,bmp,png,3gp,flv,mp4,avi,mov',
        'position_order' => 'required|integer',
        'is_visible' => 'required|integer'
    ];

    public function getLabel()
    {
        return "Gallery";
    }

    public function performers()
    {
        return $this->belongsToMany(Performer::class, 'performer_galleries', 'gallery_id');
    }

    public function getFormattedValue()
    {
        return $this->title;
    }

    public function getFormattedValueColumn()
    {
        return ['title'];
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
        $default = isset(DefaultConfig::getConfig()['gallery_type']) ? DefaultConfig::
        getConfig()['gallery_type'] : null;
        if ($default) {
            return $default;
        }
        return [
            self::TYPE_IMAGE => "Image",
            self::TYPE_VIDEO => "Video"
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
            "title" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Title"
            ],
            "description" => [
                "type" => self::TYPE_TEXTAREA,
                "visible" => false,
                "formdisplay" => false,
                "required" => false,
                "relation" => null,
                "label" => "Description"
            ],
            "url" => [
                "type" => self::TYPE_TEXT,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Youtube Embed URL"
            ],
            "content" => [
                "type" => self::TYPE_FILE,
                "visible" => false,
                "formdisplay" => true,
                "required" => $this->id ? false : true,
                "relation" => null,
                "label" => "Content"
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

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            if ($model->type) {
                Cache::forget('top8_galleries_by_order');
            }
        });

        static::deleted(function ($model) {
            if ($model->type) {
                Cache::forget('top8_galleries_by_order');
            }
        });
    }
}
