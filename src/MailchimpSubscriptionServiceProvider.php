<?php

namespace AscentCreative\MailchimpSubscription;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Routing\Router;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Schema;


class MailchimpSubscriptionServiceProvider extends ServiceProvider
{

    public function register() {
        //
    
        $this->mergeConfigFrom(
            __DIR__.'/../config/mailchimp-subscription.php', 'mailchimp-subscription'
        );

    }

    public function boot() {
        $this->bootComponents();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'mailchimp-subscription');

        $this->loadRoutesFrom(__DIR__.'/../routes/mailchimp-subscription-web.php');

//         $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

       

    }


    // register the components
    public function bootComponents() {
      
    }


    public function bootPublishes() {

      $this->publishes([
        __DIR__.'/Assets' => public_path('vendor/ascentcreative/mailchimp-subscription'),
    
      ], 'public');

      $this->publishes([
        __DIR__.'/config/mailchimp-subscription.php' => config_path('mailchimp-subscription.php'),
      ]);

    }



}