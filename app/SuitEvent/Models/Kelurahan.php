<?php

namespace App\SuitEvent\Models;

use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| all_kelurahan Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * kecamatan_id INT(10) UNSIGNED
| * code INT(10) UNSIGNED NOT NULL
| * shipment_area_code VARCHAR(16) NULL
| * name VARCHAR(50) NOT NULL
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class Kelurahan extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    protected $primaryKey = 'id';

    public $table = 'kelurahans';
    protected static $bufferAttributeSettings = null;

    public $fillable = [
        'code',
        'shipment_area_code',
        'name',
        'kecamatan_id'
    ];

    public $rules = [
        'code' => 'required',
        'name' => 'required',
        'kecamatan_id' => 'required'
    ];

    // RELATIONSHIP
    /**
     * Get kecamatan that owns the kelurahan.
     * @return \App\SuitEvent\Models\Kecamatan|null
     */
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function getLabel()
    {
        return 'Kelurahan';
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
            'kecamatan_id' => [
                'type' => self::TYPE_NUMERIC,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => 'kecamatan',
                'label' => 'Kecamatan Name',
                'options' => (new Kecamatan)->all()->pluck('name', 'id'),
            ],
            'name' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Kelurahan Name'
            ],
            'code' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'ID Kelurahan'
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
