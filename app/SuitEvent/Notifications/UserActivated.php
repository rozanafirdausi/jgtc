<?php

namespace App\SuitEvent\Notifications;

class UserActivated extends BaseNotification
{
    protected $view = 'emails.users.activated';

    public function setMessage($notifiable)
    {
        $this->message = trans('notification.messages.users.activated');
    }
}
