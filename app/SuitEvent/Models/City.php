<?php

namespace App\SuitEvent\Models;

use Cache;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| all_kabkot Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * province_id INT(10) UNSIGNED
| * code VARCHAR(32) NOT NULL
| * shipment_area_code VARCHAR(16) NULL
| * name VARCHAR(128) NOT NULL
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class City extends SuitModel
{
    use BlameableTrait;
    // MODEL DEFINITION
    protected $primaryKey = 'id';

    public $table = 'kabkotas';
    protected static $bufferAttributeSettings = null;

    public $fillable = [
        'code',
        'shipment_area_code',
        'name',
        'province_id'
    ];

    public $rules = [
        'code' => 'required',
        'name' => 'required',
        'province_id' => 'required'
    ];

    // RELATIONSHIP
    /**
     * Get the province of the city.
     * @return \App\SuitEvent\Models\Province|null
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    /**
     * Get kecamatans of the city.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function kecamatans()
    {
        return $this->hasMany(Kecamatan::class, 'kabkota_id');
    }

    public function getLabel()
    {
        return 'City';
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
        return 'name';
    }

    public function getDefaultOrderColumnDirection()
    {
        return 'asc';
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
            'province_id' => [
                'type' => self::TYPE_NUMERIC,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => 'province',
                'label' => 'Province Name',
                'options' => (new Province)->all()->pluck('name', 'id'),
            ],
            'name' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Kab / Kota Name'
            ],
            'code' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'ID Kab / Kota'
            ],
            'shipment_area_code' => [
                'type' => self::TYPE_TEXT,
                'visible' => false,
                'formdisplay' => false,
                'required' => false,
                'relation' => null,
                'label' => 'Shipment Area Code'
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

    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            Cache::forever('city_list', City::get());
        });

        static::deleted(function ($model) {
            Cache::forever('city_list', City::get());
        });
    }
}
