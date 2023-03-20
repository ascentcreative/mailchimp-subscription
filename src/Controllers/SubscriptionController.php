<?php
namespace AscentCreative\MailchimpSubscription\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use AscentCreative\MailchimpSubscription\Events\EmailSignupRequested;
use AscentCreative\MailchimpSubscription\Events\UnsubscribeRequested;
use AscentCreative\MailchimpSubscription\Events\ResendConfirmationRequested;


use AscentCreative\MailchimpSubscription\Exceptions\APIException;

class SubscriptionController extends Controller
{

    public function renderstatus() {

        $mailchimp = new \MailchimpMarketing\ApiClient();

        $mailchimp->setConfig([
            'apiKey' => config('mailchimp-subscription.api_key'),
            'server' => config('mailchimp-subscription.server_prefix')
        ]);

        $list_id = config('mailchimp-subscription.audience_id');


        // $mailchimp->subscriberHash($email);

        $email = auth()->user()->email;

        $status = '';
        try {
            $response = $mailchimp->lists->getListMember($list_id, md5($email));
            // dd($response);
            $status = $response->status; //"Subscribed";
        } catch (\MailchimpMarketing\ApiException $e) {
            echo $e->getMessage();
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            if($e->getCode() == 404) {
                $status = "not-found";
            }
            // dump($e);
        }
        // print_r($response);

        return view('mailchimp-subscription::subscription-status.' . $status);

    }   
   
    public function subscribe() {

        try {
            EmailSignupRequested::dispatch(auth()->user(), false);
        } catch (APIException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
        
    }


    public function unsubscribe() {

        UnsubscribeRequested::dispatch(auth()->user(), false);

    }

    public function resend() {

        ResendConfirmationRequested::dispatch(auth()->user(), false);

    }

}