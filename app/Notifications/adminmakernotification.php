<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class adminmakernotification extends Notification
{
    use Queueable;
    protected $group;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($group)
    {
        $this->group=$group;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
        'database',
       ];
    }

    public function toDatabase($notifiable)
    {
        $groupName = $this->group->name;
        $title = '<img class="person-img" src="/profile-images/' . $notifiable->profile->image . '" alt="person img">';

        return [
            'title' => $title,
            'body' => __('تم جعلك مشرفا في المجموعة') . ' ' . $groupName,
            'icon' => '',
            'url' => '/book-page/' .$this->group->id,
        ];
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
