<?php

namespace AscentCreative\MailchimpSubscription\Components;

use Illuminate\View\Component;

class SubscriptionStatus extends Component
{

    public $status = '';


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($email, $list='xyz')
    {
       

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('mailchimp-subscription::subscription-status.base'); // . $this->status);
    }
}
