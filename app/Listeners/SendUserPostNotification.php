<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\UserPostNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendUserPostNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $admin = User::where('role_id', 1)->first();
        Notification::send($admin, new UserPostNotification($event->post));
    }
}
