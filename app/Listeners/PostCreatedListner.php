<?php

namespace App\Listeners;

use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use function Symfony\Component\Console\Style\success;

class PostCreatedListner
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
        cache()->forget('posts');
        $posts = Post::with('user', 'user.role:id,slug')
            ->get();
        cache()->forever('posts', $posts);

        Notification::send();




        info('successfully cached');
    }
}
