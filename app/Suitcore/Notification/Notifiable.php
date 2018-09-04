<?php

namespace Suitcore\Notification;

trait Notifiable
{
    use HasDatabaseNotifications, RoutesNotifications;
}
