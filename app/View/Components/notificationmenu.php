<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class notificationmenu extends Component
{

    public $notifications=[];

    public $unread=0;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->notifications = $user->notifications;
            $this->unread = $user->unreadNotifications()->count();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.notificationmenu');
    }
}
