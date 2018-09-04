<?php

namespace App\SuitEvent\Notifications\Contracts;

interface EmailSettingInterface
{
    public function getSetting($template);
}
