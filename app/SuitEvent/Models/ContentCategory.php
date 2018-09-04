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
| * parent_id INT(10) NOT NULL
| * type_id INT(10) NOT NULL
| * name varchar(255) NOT NULL
| * slug varchar(255)
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class ContentCategory extends SuitModel
{
    use BlameableTrait;

    // MODEL DEFINITION
    public $table = 'content_categories';
    protected static $bufferAttributeSettings = null;

    public $fillable = [
        'parent_id',
        'type_id',
        'name',
        'slug',
    ];

    public $rules = [
        'type_id' => 'required',
        'name' => 'required'
    ];

    public function type()
    {
        return $this->belongsTo(ContentType::class, 'type_id');
    }

    public function parentCategory()
    {
        return $this->belongsTo(ContentCategory::class, 'parent_id');
    }

    public function getLabel()
    {
        return "Content Category";
    }

    public function getFormattedValue()
    {
        return $this->name;
    }

    public function getFormattedValueColumn()
    {
        return ['name'];
    }

    public function getOptions()
    {
        return self::all();
    }

    public function getDefaultOrderColumn()
    {
        return 'name';
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
            "parent_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => false,
                "relation" => "parentCategory",
                "label" => "Parent Category",
                "options" => (new ContentCategory)->all()->pluck('name', 'id')
            ],
            "type_id" => [
                "type" => self::TYPE_NUMERIC,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => "type",
                "label" => "Type",
                "options" => (new ContentType)->all()->pluck('name', 'id')
            ],
            "name" => [
                "type" => self::TYPE_TEXT,
                "visible" => true,
                "formdisplay" => true,
                "required" => true,
                "relation" => null,
                "label" => "Name"
            ],
            "slug" => [
                "type" => self::TYPE_TEXT,
                "visible" => false,
                "formdisplay" => true,
                "required" => false,
                "relation" => null,
                "label" => "Slug"
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

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = str_slug($model->name);
            }
        });

        static::updating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = str_slug($model->name);
            }
        });

        static::saved(function ($model) {
            if ($model->type) {
                Cache::forever('content_category_for_type_' . $model->type->code, ContentCategory::
                    where('type_id', '=', $model->type->id)->get()->keyBy('slug'));
            }
        });

        static::deleted(function ($model) {
            if ($model->type) {
                Cache::forever('content_category_for_type_' . $model->type->code, ContentCategory::
                    where('type_id', '=', $model->type->id)->get()->keyBy('slug'));
            }
        });
    }
}
