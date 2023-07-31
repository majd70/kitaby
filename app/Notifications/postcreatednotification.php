<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

use Illuminate\Notifications\Notification;

class postcreatednotification extends Notification
{
    use Queueable;

    protected $post;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return  [
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

    public function toDatabase($notifiable) //هدول تلميثود بحدد شكل الداتا الي حتنبعث ل للتشانيل الخاصة فيها
    {
        $userName = $this->post->user->name;
        $groupName = $this->post->group ? $this->post->group->name : '';
        $title = '<img class="person-img" src="/profile-images/' . $this->post->user->profile->image . '" alt="person img"> ' ;
           return [
             'title'=>$title ,
             'body' => __('تم النشر بواسطة') . ' ' . $userName . ' ' . __('في مجموعة') . ' ' . $groupName,
             'icon' =>'' ,
             'url' => route('posts.show', ['post' => $this->post->id]),
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
