<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\Settings;
use App\SuitEvent\Repositories\Contracts\SettingsRepositoryContract;
use Cache;
use Input;
use Redirect;
use Suitcore\Repositories\SuitRepository;
use Upload;
use View;

class SettingsRepository extends SuitRepository implements SettingsRepositoryContract
{
    public function __construct()
    {
        $this->mainModel = new Settings;
    }

    /**
     * Update setting by key.
     * @param string $key
     * @param string $value
     * @return void
     */
    public function updateByKey($key, $value)
    {
        $setting = Settings::firstOrNew(['key' => $key]);
        if (!($hasFile = request()->hasFile('settings.' . $key))) {
            $setting->value = $value;
        }
        if ($hasFile) {
            $setting->value = $value;
            Upload::setFilenameMaker(function ($file, $object) {
                $title = $object->getFormattedValue();
                return $key . '.' . $file->getClientOriginalExtension();
            }, $object);

            Upload::model($object);
        }
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
    public function getValue($key, $default = '')
    {
        $setting = Cache::rememberForever('settings', function () {
            return Settings::pluck('value', 'key');
        });
        return isset($setting[$key]) ? $setting[$key] : $default;
    }

    /**
     * Save settings
     * @param array $settingArray
     * @return boolean
     */
    public function save($settingArray)
    {
        $result = false;
        if (is_array($settingArray)) {
            try {
                foreach ($settingArray as $key => $value) {
                    $result = $this->updateByKey($key, $value);
                }
            } catch (Exception $e) {
            }
        }
        return $result;
    }
}
