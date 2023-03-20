<?php

namespace AscentCreative\MailchimpSubscription\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SyncSubscriptionListener extends SubscriptionListener
{

    public $connection = 'sync';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //)
    }

    public function shouldQueue($event):bool {
        // dump($event);
        // return true;
        return $event->listenerShouldQueue != 1;
    }

   
}
