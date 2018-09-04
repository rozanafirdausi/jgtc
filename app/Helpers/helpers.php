<?php

use App\SuitEvent\Config\DefaultConfig;
use App\SuitEvent\Models\AppConfig;
use App\SuitEvent\Models\Notification;
use App\SuitEvent\Models\Settings;
use App\SuitEvent\Repositories\MenuRepository;
use App\SuitEvent\Repositories\NotificationRepository;

if (! function_exists('defaultConfig')) {

    function defaultConfig()
    {
        return DefaultConfig::getConfig();
    }
}

if (! function_exists('settings')) {

    function settings($key, $default = null)
    {
        return app(Settings::class)->getValue($key, $default);
    }
}

if (! function_exists('updatesetting')) {

    function updatesetting($key, $value)
    {
        Settings::updateByKey($key, $value);
    }
}

if (! function_exists('getHeaderDropDownList')) {

    function getHeaderDropDownList($class)
    {
        return app($class)->getHeaderDropDownList();
    }
}

if (! function_exists('notifCounter')) {
    function notifCounter()
    {
        $notificationRepo = new NotificationRepository;
        return (
            $nbNotification = $notificationRepo->getNotificationCount(auth()->user())
        ) < 99 ? $nbNotification : "99+";
    }
}

if (! function_exists('appConfig')) {

    function appConfig($key = null)
    {
        if ($key == null) {
            return app(AppConfig::class);
        }

        $data = AppConfig::$data;

        return array_get($data, $key);
    }
}

if (! function_exists('isEmptyDate')) {

    function isEmptyDate($date)
    {
        return ($date == null || empty($date) || $date == "0000-00-00 00:00:00" || $date == "0000-00-00");
    }
}

if (! function_exists('generateRandomString')) {

    function generateRandomString($length = 5)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($characters, $length)), 0, $length);
    }
}

if (! function_exists('startsWith')) {
    function startsWith($haystack, $needle)
    {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }
}

if (! function_exists('endsWith')) {
    function endsWith($haystack, $needle)
    {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 &&
        strpos($haystack, $needle, $temp) !== false);
    }
}

if (! function_exists('asPhoneNumberDestination')) {

    function asPhoneNumberDestination($text)
    {
        return str_replace(['-', ' '], '', $text);
    }
}

if (! function_exists('getUsernameByEmail')) {

    function getUsernameByEmail($email, $useDot = false)
    {
        $username = str_replace(substr($email, strpos($email, '@')), '', $email);

        if ($useDot) {
            return $username;
        }

        return str_replace('.', '', $username);
    }
}

if (! function_exists('isValid')) {

    function isValid($test, $rules)
    {
        $validator = Validator::make(compact('test'), ['test' => $rules]);
        return $validator->passes();
    }
}

if (! function_exists('getActiveMenu')) {

    function getActiveMenu($position)
    {
        $menus = [];
        try {
            $menus = app(MenuRepository::class)->getActiveMenu($position);
        } catch (\Exception $e) {
            //
        }
        return $menus;
    }
}
