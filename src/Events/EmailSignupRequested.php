<?php

namespace AscentCreative\MailchimpSubscription\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use AscentCreative\MailchimpSubscription\Contracts\Subscribable;

use App\Models\User;

class EmailSignupRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $listenerShouldQueue;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Subscribable $user, $listenerShouldQueue=true)
    {

        //
        // dump('here');
        $this->user = $user;
        $this->listenerShouldQueue = $listenerShouldQueue;

    }

}
