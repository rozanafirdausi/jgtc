<?php

namespace App\SuitEvent\Notifications\EmailSetting;

trait EmailSettingTrait
{
    public function getSetting($template)
    {
        $setting = static::where('template', $template)->first();
        return $setting ? $setting->toArray() : null;
    }
}
