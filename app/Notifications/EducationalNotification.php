<?php

namespace App\Notifications;

use App\Broadcasting\CustomDatabaseChannel;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EducationalNotification extends Notification
{
    use Queueable;

    private $notifier_type;
    private $notifier_id;
    private $deadline;
    private $title;
    private $brief_description;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notifier_type, $notifier_id, $deadline, $title, $brief_description)
    {
        $this->notifier_type = $notifier_type;
        $this->notifier_id = $notifier_id;
        $this->deadline = $deadline;
        $this->title = $title;
        $this->brief_description = $brief_description;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [CustomDatabaseChannel::class, 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
//        return (new MailMessage)
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', url('/'))
//                    ->line('Thank you for using our application!');
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'notifier_type' => $this->notifier_type,
            'notifier_id' => $this->notifier_id,
            'deadline' => $this->deadline,
            'title' => $this->title,
            'brief_description' => $this->brief_description,
            'RepliedTime' => Carbon::now()
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'time' => Carbon::now()
        ]);
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
