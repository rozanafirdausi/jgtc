<?php

namespace App\SuitEvent\Models;

use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| all_kecamatan Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * kabkota_id INT(10) UNSIGNED
| * code INT(10) UNSIGNED NOT NULL
| * shipment_area_code VARCHAR(16) NULL
| * name VARCHAR(50) NOT NULL
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class Kecamatan extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    protected $primaryKey = 'id';

    public $table = 'kecamatans';
    protected static $bufferAttributeSettings = null;

    public $fillable = [
        'code',
        'shipment_area_code',
        'name',
        'kabkota_id'
    ];

    public $rules = [
        'code' => 'required',
        'name' => 'required',
        'kabkota_id' => 'required'
    ];

    // RELATIONSHIP
    /**
     * Get the city of the kecamatan.
     * @return \App\SuitEvent\Models\City|null
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'kabkota_id');
    }

    /**
     * Get kelurahans of the kecamatan.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function kelurahans()
    {
        return $this->hasMany(Kelurahan::class);
    }

    public function getLabel()
    {
        return 'Kecamatan';
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
            'kabkota_id' => [
                'type' => self::TYPE_NUMERIC,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => 'city',
                'label' => 'Kab / Kota',
                'options' => (new City)->all()->pluck('name', 'id'),
            ],
            'name' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Kecamatan Name'
            ],
            'code' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'ID Kecamatan'
            ],
            'shipment_area_code' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
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
}
