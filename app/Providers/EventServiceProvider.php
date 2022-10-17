<?php

namespace App\Providers;

use App\Events\PostSaved;
use App\Events\UserRegistrationEvent;
use App\Listeners\PostCreatedListner;
use App\Listeners\SendNewUserNotification;
use App\Listeners\SendUserPostNotification;
use App\Listeners\UserRegistrationNotificationListner;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            SendNewUserNotification::class,
            SendUserPostNotification::class,
        ],

        UserRegistrationEvent::class => [
            UserRegistrationNotificationListner::class
        ],

        PostSaved::class => [
            PostCreatedListner::class,
        ]


    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
