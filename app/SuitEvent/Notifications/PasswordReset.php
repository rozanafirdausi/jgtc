<?php

namespace App\SuitEvent\Notifications;

use App\SuitEvent\Notifications\BaseNotification;

class PasswordReset extends BaseNotification
{
    protected $view = 'emails.auth.resetpassword';
    protected $user;

    public function __construct($user, $link = null)
    {
        parent::__construct($link);
        $this->user = $user;
    }

    public function setDataView($notifiable)
    {
        $this->dataView = ['user' => $this->user];
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return parent::toMail($notifiable);
    }
}
