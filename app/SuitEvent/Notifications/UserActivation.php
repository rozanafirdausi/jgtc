<?php

namespace App\SuitEvent\Notifications;

class UserActivation extends BaseNotification
{
    protected $view = 'emails.users.activation';

    // only notif by email
    public function via($notifiable)
    {
        return ['mail'];
    }
}
