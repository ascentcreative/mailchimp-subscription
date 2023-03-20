<?php

namespace AscentCreative\MailchimpSubscription\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use AscentCreative\MailchimpSubscription\Exceptions\APIException;

class SubscriptionListener implements ShouldQueue
{
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
        return $event->listenerShouldQueue == 1;
    }

    private function sendUpdate($email, $first, $last, $status, $status_new=null, $email_new=null) {

        $mailchimp = new \MailchimpMarketing\ApiClient();

        $mailchimp->setConfig([
            'apiKey' => config('mailchimp-subscription.api_key'),
            'server' => config('mailchimp-subscription.server_prefix')
        ]);

        $list_id = config('mailchimp-subscription.audience_id');

        // dump('setting ' . $email . ' to ' . $status);

        // does the user exist:
        try {
            $response = $mailchimp->lists->getListMember($list_id, md5($email));
        } catch (\GuzzleHttp\Exception\ClientException $e) { 
            // no. create.

            if($status == 'subscribed' || $status == 'pending') {
                $response = $mailchimp->lists->addListMember($list_id, [
                    "email_address" => $email,
                    "status" => $status_new ?? $status,
                    "merge_fields" => [
                        "FNAME" => $first,
                        "LNAME" => $last,
                        "EMAIL" => $email_new ?? $email,
                    ]
                ]);
            }

        }



        try {

            $response = $mailchimp->lists->updateListMember($list_id, md5($email), [
                "status_if_new" => $status_new ?? $status,
                "status" => $status,
                "merge_fields" => [
                    "FNAME" => $first,
                    "LNAME" => $last,
                    "EMAIL" => $email_new ?? $email,
                ]
            ]);
         
        } catch (MailchimpMarketing\ApiException $e) {
            echo 'here';
            echo $e->getMessage();
        } catch (\GuzzleHttp\Exception\ClientException $e) {

            $data = json_decode($e->getResponse()->getBody()->getContents());

            throw new APIException('Error from MailChimp: ' . $email . $data->detail);

        }


    }


    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handleSubscribe($event)
    {
        //
        // dump('handling subscribe');
        $this->sendUpdate(
            email: $event->user->email,
            first: $event->user->first_name,
            last: $event->user->last_name,
            status: "subscribed",
            status_new: "pending"
        );

    }

    public function handleUnsubscribe($event)
    {

        $this->sendUpdate(
            email: $event->user->email,
            first: $event->user->first_name,
            last: $event->user->last_name,
            status: "unsubscribed"
        );

    }

    public function handleReconfirm($event)
    {

        $this->sendUpdate(
            email: $event->user->email,
            first: $event->user->first_name,
            last: $event->user->last_name,
            status: "unsubscribed",
        );

        $this->sendUpdate(
            email: $event->user->email,
            first: $event->user->first_name,
            last: $event->user->last_name,
            status: "pending",
        );

    }

}
