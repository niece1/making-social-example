<?php

namespace App\Notifications;

use ReflectionClass;
use Illuminate\Notifications\Notification;

/**
 * Customize what we store in database, needs to override type field.
 *
 */
class DatabaseNotificationChannel
{
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toArray($notifiable);

        return $notifiable->routeNotificationFor('database')->create([
            'id' => $notification->id,
            'type' => (new ReflectionClass($notification))->getShortName(),
            'data' => $data,
            'read_at' => null,
        ]);
    }
}
