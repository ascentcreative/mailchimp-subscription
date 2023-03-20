<?php

use AscentCreative\MailchimpSubscription\Controllers\SubscriptionController;

Route::middleware('web')->group( function() {

    Route::get('/mailchimp/subscribe', [SubscriptionController::class, 'subscribe']);

    Route::get('/mailchimp/unsubscribe', [SubscriptionController::class, 'unsubscribe']);

    Route::get('/mailchimp/resend', [SubscriptionController::class, 'resend']);

    Route::get('/mailchimp/renderstatus', [SubscriptionController::class, 'renderstatus']);

    Route::get('mc-test', function() {
        dump(config('mailchimp-subscription.audience_id'));
    });

    // Route::get('/mailchimp/audiences', function() {
        
    //     $mailchimp = new \MailchimpMarketing\ApiClient();

    //     $mailchimp->setConfig([
    //         'apiKey' => env("MAILCHIMP_KEY"),
    //         'server' => env("MAILCHIMP_PREFIX")
    //     ]);

    //     $response = $mailchimp->lists->getAllLists();

    //     dump($response);

    // });

});