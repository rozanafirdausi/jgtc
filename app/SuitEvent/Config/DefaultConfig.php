<?php

namespace App\SuitEvent\Config;

class DefaultConfig
{
    public static function getConfig()
    {
        return array_merge(
            config('suitevent.base_config'),
            (class_exists('\\App\\Config\\BaseConfig') ? \App\Config\BaseConfig::getData() : [])
        );
    }
}
