<?php

namespace AscentCreative\MailchimpSubscription\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;


use AscentCreative\MailchimpSubscription\Events\EmailSignupRequested;
use AscentCreative\MailchimpSubscription\Events\UnsubscribeRequested;
use AscentCreative\MailchimpSubscription\Events\ResendConfirmationRequested;

use AscentCreative\MailchimpSubscription\Listeners\SubscriptionListener;
use AscentCreative\MailchimpSubscription\Listeners\SyncSubscriptionListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
            
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */

    public function register()
    {
        Event::listen(
            EmailSignupRequested::class,
            [SubscriptionListener::class, 'handleSubscribe']
        );
        Event::listen(
            EmailSignupRequested::class,
            [SyncSubscriptionListener::class, 'handleSubscribe']
        );

        Event::listen(
            UnsubscribeRequested::class,
            [SubscriptionListener::class, 'handleUnsubscribe']
        );
        Event::listen(
            UnsubscribeRequested::class,
            [SyncSubscriptionListener::class, 'handleUnsubscribe']
        );

        Event::listen(
            ResendConfirmationRequested::class,
            [SubscriptionListener::class, 'handleReconfirm']
        );
        Event::listen(
            ResendConfirmationRequested::class,
            [SyncSubscriptionListener::class, 'handleReconfirm']
        );
        
    }
}
