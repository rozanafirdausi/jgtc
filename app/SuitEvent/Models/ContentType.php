<?php

namespace App\SuitEvent\Models;

use Cache;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| articles Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * name varchar(255)
| * code varchar(32)
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class ContentType extends SuitModel
{
    use BlameableTrait;
    
    const DYNAMIC_TYPE = 'dynamic';
    const STATIC_TYPE = 'static';

    protected static $dynamicId = null;
    protected static $bufferAttributeSettings = null;

    // MODEL DEFINITION
    public $table = 'content_types';

    public $fillable = [
        'name',
        'code'
    ];

    public $rules = [
        'name' => 'required',
        'code' => 'required'
    ];

    public function scopeDynamicType($query)
    {
        return $query->where('name', static::DYNAMIC_TYPE);
    }

    public function scopeStaticType($query)
    {
        return $query->where('name', static::STATIC_TYPE);
    }

    public function categories()
    {
        return $this->hasMany(ContentCategory::class);
    }

    public static function getDynamicId()
    {
        if (static::$dynamicId === null) {
            static::$dynamicId = static::dynamicType()->first()->id;
        }

        return static::$dynamicId;
    }

    public function getFullNameAttribute()
    {
        return ucfirst($this->code) . " (" . $this->name . ")";
    }

    public function getLabel()
    {
        return "Content Type";
    }

    public function getFormattedValue()
    {
        return $this->getFullNameAttribute();
    }

    public function getFormattedValueColumn()
    {
        return ['name', 'code'];
    }

    public function getOptions()
    {
        return self::all();
    }

    public function getDefaultOrderColumn()
    {
        return 'code';
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
                "visible" => true,
                "formdisplay" => false,
                "required" => true,
                "relation" => null,
                "label" => "ID"
            ],
            "name" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Name"
            ],
            "code" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Code"
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

    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            Cache::forever('content_type_by_code', ContentType::get()->keyBy('code'));
            Cache::forever('content_category_for_type_' . $model->code, ContentCategory::
                where('type_id', '=', $model->id)->get()->keyBy('slug'));
        });

        static::deleted(function ($model) {
            Cache::forever('content_type_by_code', ContentType::get()->keyBy('code'));
            Cache::forget('content_category_for_type_' . $model->code);
        });
    }
}
