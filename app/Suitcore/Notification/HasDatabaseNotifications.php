<?php

namespace Suitcore\Notification;

use App\SuitEvent\Models\Notification;

trait HasDatabaseNotifications
{
    /**
     * Get notifications of the user.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id')
                            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the entity's unread notifications.
     */
    public function unreadNotifications()
    {
        return $this->hasMany(Notification::class, 'user_id')
                            ->whereNull('is_read')
                            ->orderBy('created_at', 'desc');
    }
}
