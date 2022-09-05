<?php

namespace NotificationChannels\GoogleChat;

use NotificationChannels\GoogleChat\Models\Space;

trait SpaceChat
{
    public function space(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Space::class, 'related')->whereNull('deleted_at');
    }

    /**
     * Route notifications for the googleChat channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForGoogleChat($notification)
    {
        return $this->space;
    }
}
