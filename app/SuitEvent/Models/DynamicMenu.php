<?php

namespace App\SuitEvent\Models;

use App\SuitEvent\Config\DefaultConfig;
use Cache;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| dynamic_menus Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * position VARCHAR(255)
| * position_order INT(10)
| * label VARCHAR(255)
| * url VARCHAR(255)
| * status VARCHAR(32)
| * parent_id INT(10) UNSIGNED
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class DynamicMenu extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    public $table = 'dynamic_menus';
    protected static $bufferAttributeSettings = null;

    const POSITION_HEADER = 'header';
    const POSITION_FOOTER = 'footer';

    // status options
    const STATUS_HIDDEN = 0;
    const STATUS_ALL = 1;
    const STATUS_AUTH_USER = 2;
    const STATUS_GUEST = 3;
    const STATUS_DISABLE = 9;

    public $fillable = [
        'position',
        'position_order',
        'label',
        'url',
        'status',
        'parent_id',
    ];

    public $casts = [
        'status' => 'integer'
    ];

    public $rules = [
        'position' => 'required',
        'label' => 'required',
        'url' => 'required',
        'status' => 'required',
    ];

    // RELATIONSHIP
    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', static::STATUS_ALL);
    }

    public function getLinkAttribute()
    {
        return url($this->url);
    }

    public function getLabel()
    {
        return 'Menu';
    }

    public function getFormattedValue()
    {
        return $this->label;
    }

    public function getFormattedValueColumn()
    {
        return ['label'];
    }

    public function getStatusOptions()
    {
        return [
            static::STATUS_HIDDEN => 'Hidden',
            static::STATUS_ALL => 'Visible (All User)',
            static::STATUS_AUTH_USER => 'Visible (Authenticated User)',
            static::STATUS_GUEST => 'Visible (Guest)',
            static::STATUS_DISABLE => 'Disable'
        ];
    }

    public function getPositionOptions()
    {
        $default = isset(DefaultConfig::getConfig()['menu_position']) ? DefaultConfig::
        getConfig()['menu_position'] : null;

        if ($default) {
            return $default;
        }

        return [
            static::POSITION_HEADER => title_case(static::POSITION_HEADER),
            static::POSITION_FOOTER => title_case(static::POSITION_FOOTER),
        ];
    }

    public function getDefaultOrderColumn()
    {
        return 'position';
    }

    public function getDefaultOrderColumnDirection()
    {
        return 'desc';
    }

    public function getAttributeSettings()
    {
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
            'position' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Position (Type)',
                'options' => $this->getPositionOptions(),
                "filterable" => true
            ],
            'position_order' => [
                'type' => self::TYPE_NUMERIC,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Order'
            ],
            'label' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Label',
            ],
            'url' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'URL',
            ],
            'status' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Status',
                'options' => $this->getStatusOptions(),
                'filterable' => true
            ],
            'parent_id' => [
                'type' => self::TYPE_NUMERIC,
                'visible' => true,
                'formdisplay' => true,
                'required' => false,
                'relation' => 'parent',
                'label' => 'Parent',
                'options' => static::where('id', '<>', $this->id)->pluck('label', 'id')
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

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($menu) {
            Cache::forget('dynamic_menus_' . $menu->position);
        });

        static::deleted(function ($menu) {
            Cache::forget('dynamic_menus_' . $menu->position);
        });
    }
}
