<?php

namespace Suitcore\Notification;

use Illuminate\Support\Str;
use Illuminate\Contracts\Notifications\Dispatcher;

trait RoutesNotifications
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $instanceName
     * @param  mixed  $params
     * @return void
     */
    public function notify($instanceName, ...$params)
    {
        if (is_object($instanceName) || class_exists($instanceName)) {
            return app(Dispatcher::class)->send([$this], $instanceName);
        }

        $instanceClass = 'App\\Notifications\\'.$instanceName;

        $instanceClass = class_exists($instanceClass) ?
                    $instanceClass :
                    config('suitapp.notifications.namespace', 'Suitcore\\Notifications\\').$instanceName;

        if (class_exists($instanceClass)) {
            $instance = new $instanceClass(...$params);

            if (isset($this->emailPreview) && $this->emailPreview) {
                return $instance->toMail($this);
            }

            app(Dispatcher::class)->send([$this], $instance);
        }
    }

    /**
     * Get the notification routing information for the given driver.
     *
     * @param  string  $driver
     * @return mixed
     */
    public function routeNotificationFor($driver)
    {
        if (method_exists($this, $method = 'routeNotificationFor'.Str::studly($driver))) {
            return $this->{$method}();
        }

        switch ($driver) {
            case 'database':
                return $this->notifications();
            case 'mail':
                return $this->email;
            case 'nexmo':
                return $this->phone_number;
        }
    }
}
