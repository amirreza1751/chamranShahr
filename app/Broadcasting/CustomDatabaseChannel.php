<?php

namespace App\Broadcasting;

use App\User;
use Illuminate\Notifications\Channels\DatabaseChannel;
use Illuminate\Notifications\Notification;

class CustomDatabaseChannel extends DatabaseChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\User  $user
     * @return array|bool
     */
    public function join(User $user)
    {
        //
    }

    /**
     * Build an array payload for the DatabaseNotification Model.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array
     */
    protected function buildPayload($notifiable, Notification $notification)
    {
        return [
            'id' => $notification->id,
            'type' => get_class($notification),
            'notifier_id' => $this->getData($notifiable, $notification)['notifier_id'],
            'notifier_type' => $this->getData($notifiable, $notification)['notifier_type'],
            'deadline' => $this->getData($notifiable, $notification)['deadline'],
            'data' => array_except($this->getData($notifiable, $notification), ['notifier_id', 'notifier_type', 'deadline']),
            'read_at' => null,
        ];
    }
}
