<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\AdminPostNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewUserNotification
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
//        $users = User::where('role_id', 2)->get();
//        Notification::send($users, new AdminPostNotification($event->user));
    }
}
