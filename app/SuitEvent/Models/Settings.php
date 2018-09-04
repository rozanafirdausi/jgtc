<?php

namespace App\SuitEvent\Models;

use Cache;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Suitcore\Models\SuitModel;

/*
|--------------------------------------------------------------------------
| settings Table Structure
|--------------------------------------------------------------------------
| * id INT(10) NOT NULL
| * key VARCHAR(255) NOT NULL
| * value TEXT NOT NULL
| * created_at TIMESTAMP
| * updated_at TIMESTAMP
*/
class Settings extends SuitModel
{
    use BlameableTrait;
    
    // MODEL DEFINITION
    public $table = 'settings';
    protected static $bufferAttributeSettings = null;

    protected $primaryKey = 'key';

    public $fillable = [
        'key',
        'value'
    ];

    public $casts = [
        'key' => 'string',
        'value' => 'string'
    ];

    public $rules = [
        'key' => 'required'
    ];

    // SERVICES (temporary included in model, since may be there is frontend module access these static functions)
    /**
     * Update setting by key.
     * @param string $key
     * @param string $value
     * @return void
     */
    public static function updateByKey($key, $value)
    {
        $setting = Settings::firstOrNew(['key' => $key]);
        $setting->value = $value;
        $result = $setting->save();
        if ($result) {
            // Begin Update Cache
            Cache::forever('settings', Settings::pluck('value', 'key'));
            // Finish Update Cache
        }
    }

    /**
     * Get value of setting.
     * @param string $key
     * @param  string $default
     * @return string
     */
    public static function getValue($key, $default = '')
    {
        $setting = Cache::rememberForever('settings', function () {
            return Settings::pluck('value', 'key');
        });
        return isset($setting[$key]) ? $setting[$key] : $default;
    }

    public function getLabel()
    {
        return 'Setting';
    }

    public function getFormattedValue()
    {
        return $this->key;
    }

    public function getDefaultOrderColumn()
    {
        return 'created_at';
    }

    public function getDefaultOrderColumnDirection()
    {
        return 'desc';
    }

    public function getAttributeSettings()
    {
        return [
            'id' => [
                'type' => self::TYPE_NUMERIC,
                'visible' => true,
                'formdisplay' => false,
                'required' => true,
                'relation' => null,
                'label' => 'ID'
            ],
            'key' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Key'
            ],
            'value' => [
                'type' => self::TYPE_TEXT,
                'visible' => true,
                'formdisplay' => true,
                'required' => true,
                'relation' => null,
                'label' => 'Value'
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
