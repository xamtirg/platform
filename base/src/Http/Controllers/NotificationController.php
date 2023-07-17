<?php

namespace Xamtirg\Base\Http\Controllers;

use Xamtirg\Base\Models\AdminNotification;
use Carbon\Carbon;

class NotificationController extends BaseController
{
    public function getNotification()
    {
        $notifications = AdminNotification::query()
            ->latest()
            ->paginate(10);

        $notificationCollection = $notifications->getCollection();

        foreach ($notificationCollection as $key => $notification) {
            if (! $notification->isAbleToAccess()) {
                $notificationCollection->forget($key);
            }
        }

        $notifications->setCollection($notificationCollection);

        return view('core/base::notification.partials.notification-item', compact('notifications'));
    }

    public function countNotification()
    {
        $countNotificationUnread = AdminNotification::countUnread();

        return view('core/base::notification.partials.count-notification-unread', compact('countNotificationUnread'));
    }

    public function delete($id)
    {
        $notificationItem = AdminNotification::query()->findOrFail($id);
        $notificationItem->delete();

        if (! AdminNotification::query()->exists()) {
            return [
                'view' => view('core/base::notification.partials.sidebar-notification')->render(),
            ];
        }

        return [];
    }

    public function deleteAll()
    {
        AdminNotification::query()->delete();

        return view('core/base::notification.partials.sidebar-notification');
    }

    public function read($id)
    {
        $notificationItem = AdminNotification::query()->findOrFail($id);

        if ($notificationItem->read_at === null) {
            $notificationItem->markAsRead();
        }

        if (! $notificationItem->action_url || $notificationItem->action_url == '#') {
            return redirect()->back();
        }

        return redirect()->to(url($notificationItem->action_url));
    }

    public function readAll()
    {
        AdminNotification::query()
            ->whereNull('read_at')
            ->update([
                'read_at' => Carbon::now(),
            ]);

        return [];
    }
}
