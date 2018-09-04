<?php

namespace App\SuitEvent\Notifications;

class UserRegistered extends BaseNotification
{
    protected $view = 'emails.users.registered';

    // only notif by email
    public function via($notifiable)
    {
        return ['mail'];
    }
}
