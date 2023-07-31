<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class categorycreatednotification extends Notification
{
    use Queueable;

    public $category;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($category)
    {
        $this->category=$category;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return
        [
           'database',
           //FcmChannel::class,
           //'mail',
           'broadcast'

       ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }


    public function toDatabase($notifiable)
{
    $title = '<img class="person-img" src="' . asset('assets/images/Logo.png') . '" alt="person img"> ';

    return [
        'title' => $title,
        'body' => __('جديد!..تم إضافة تصنيف جديد إلى منصتنا'),
        'icon' => '',
        'url' => url('/all-books/' . $this->category->id),
    ];
}

    public function toBroadcast($notifiable) //هدول تلميثود بحدد شكل الداتا الي حتنبعث ل للتشانيل الخاصة فيها
    {
           return new BroadcastMessage(
            [
            'title'=>__('New category') ,
            'body' => __(),
            'icon' =>'' ,
            'url'=> url('/') //where he go when click on notification,
          ]
          ) ;
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
