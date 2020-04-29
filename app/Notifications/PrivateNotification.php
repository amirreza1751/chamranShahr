<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class PrivateNotification extends Notification
{
    use Queueable;
    public $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }


    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('چمرانشهر - نوتیفیکیشن')
            ->icon('https://campus.scu.ac.ir/web/static/media/Logo.eae4a32a.png?__WB_REVISION__=eae4a32a77d0d0047e42b74590bdd9d2')
            ->body($this->message . "___" .Carbon::now()->toDateTimeString())
//            ->image('https://static.vecteezy.com/system/resources/previews/000/165/953/original/free-business-success-icons-vector.jpg')
            ->action('نمایش در اپلیکیشن', 'https://campus.scu.ac.ir/build');
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
