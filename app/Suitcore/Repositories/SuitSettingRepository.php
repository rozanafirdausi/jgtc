<?php

namespace Suitcore\Repositories;

use Suitcore\Models\SuitSetting;
use Cache;
use Suitcore\Repositories\Contract\SuitSettingRepositoryContract;

class SuitSettingRepository implements SuitSettingRepositoryContract
{   
    protected $mainModel = null;

    /**
     * Default Constructor
     **/
    public function __construct()
    {
        $this->mainModel = new SuitSetting;
    }

	/**
     * Update setting by key.
     * @param string $key
     * @param string $value
     * @return void
     */
    public function updateByKey($key, $value)
    {
        $baseModel = ($this->mainModel ? $this->mainModel->getNew() : new SuitSetting);
        $setting = $baseModel->firstOrNew(['key' => $key]);
        $setting->value = $value;
        //if (request()->hasFile($key)) {
        //    $this->doUpload($setting);
        //}
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
        $baseModel = ($this->mainModel ? $this->mainModel->getNew() : new SuitSetting);
        $setting = Cache::rememberForever('settings', function () use($baseModel) {
            return $baseModel->pluck('value', 'key');
        });
        return isset($setting[$key]) ? $setting[$key] : $default;
    }

    /**
     * Save settings
     * @param array $settingArray
     * @return boolean
     */
	public function save($settingArray) {
		$result = false;
		if (is_array($settingArray)) {
			try {
				foreach ($settingArray as $key => $value) {
					$result = $this->updateByKey($key, $value);
				}
			} catch (Exception $e) { }
		}
		return $result;
	}
}
