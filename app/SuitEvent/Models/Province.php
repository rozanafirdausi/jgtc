<?php

namespace App\SuitEvent\Models;

use Cache;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| all_provinsi Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * code INT(10) UNSIGNED NOT NULL
| * shipment_area_code VARCHAR(16) NULL
| * name VARCHAR(50) NOT NULL
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class Province extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION

    public $table = 'provinces';
    protected static $bufferAttributeSettings = null;

    public $fillable = [
        'code',
        'shipment_area_code',
        'name'
    ];

    public $rules = [
        'code' => 'required',
        'name' => 'required'
    ];

    // RELATIONSHIP
    /**
     * Get cities of the province.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    // SERVICES
    /**
     * Get the default name of province.
     * @return string
     */
    public static function getDefault()
    {
        return "DKI Jakarta";
    }

    /**
     * Get collection of all province.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function allProvinces()
    {
        return Cache::remember('provinces', 60, function () {
            return Province::get();
        });
    }

    /**
     * Get list of all province.
     * @return array
     */
    public static function getHeaderDropDownList()
    {
        $lists = [];
        $provinces = Province::allProvinces();

        $lists[0]['key_prov'] = 'all';
        $lists[0]['name_prov'] = 'Seluruh Daerah';
        foreach ($provinces as $province) {
            $lists[$province->code]['key_prov'] = $province->name;
            $lists[$province->code]['name_prov'] = $province->name;
        }
        return $lists;
    }

    public function getLabel()
    {
        return 'Province';
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
            'name' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Name'
            ],
            'code' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Code'
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
}
