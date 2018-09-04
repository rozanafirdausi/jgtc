<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\Notification;
use Cache;
use Carbon\Carbon;
use DB;
use Suitcore\Repositories\SuitRepository;

class NotificationRepository extends SuitRepository
{
    /* CONSTANTS */
    const SHOWALL = 0;
    // -- action to message
    const ACTION_READ = "read";
    const ACTION_UNREAD = "unread";

    /* CONSTRUCTOR AND SERVICES */
    public function __construct()
    {
        $this->mainModel = new Notification;
        $this->dependencies = ['user'];
    }

    /**
     * Add new notification.
     * @param int $relatedUserId
     * @param string $message
     * @return void
     */
    public function add($relatedUserId, $message, $url = null)
    {
        return $this->create([
            'user_id' => $relatedUserId,
            'message' => $message,
            'url' => $url
        ]);
    }

    /**
     * Get the number of notification for a specific user.
     * @param \App\SuitEvent\Models\User $user
     * @return int
     */
    public static function getNotificationCount($user)
    {
        if ($user && $user->id > 0) {
            return Cache::rememberForever('notification_counter_' . $user->id, function () use ($user) {
                $notifs = Notification::where('user_id', $user->id)->where('is_read', false)->get();
                return ($notifs ? $notifs->count() : 0);
            });
        }
        return 0;
    }

    public function read(array $ids = [])
    {
        $notifications = $this->mainModel->whereIn('id', $ids)->get();
        foreach ($notifications as $notification) {
            $notification->update(['is_read' => true]);
        }
    }

    public function deleteSelected(array $ids = [])
    {
        $notifications = $this->mainModel->whereIn('id', $ids)->get();
        foreach ($notifications as $notification) {
            $notification->delete($notification);
        }
    }
}
