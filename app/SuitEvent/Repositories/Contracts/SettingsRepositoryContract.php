<?php

namespace App\SuitEvent\Repositories\Contracts;

interface SettingsRepositoryContract
{
    public function updateByKey($key, $value);

    public function getValue($key, $default);

    public function save($settingArray);
}
