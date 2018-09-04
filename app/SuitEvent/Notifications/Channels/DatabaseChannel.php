<?php

namespace App\SuitEvent\Notifications\Channels;

use App\SuitEvent\Repositories\NotificationRepository;
use Illuminate\Notifications\Notification;

class DatabaseChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        return (new NotificationRepository)->add(...$notification->toDatabase($notifiable));
    }
}
