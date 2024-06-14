<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot() : void
    {
        parent::boot();

        Event::listen(Login::class, function ($event) {
            activity('auth-login')
                ->causedBy($event->user)
                ->withProperties(['ip' => request()->ip(), 'agent' => request()->userAgent()])
                ->log('User Login');
        });

        Event::listen(Logout::class, function ($event) {
            activity('auth-logout')
                ->causedBy($event->user)
                ->withProperties(['ip' => request()->ip(), 'agent' => request()->userAgent()])
                ->log('User Logout');
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents() : bool
    {
        return false;
    }
}
