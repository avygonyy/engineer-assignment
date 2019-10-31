<?php

namespace App\Providers;

use App\Services\MailchimpService;
use App\Services\SubscriptionService;
use Illuminate\Support\ServiceProvider;

class SubscriptionProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SubscriptionService::class, function ($app) {
            return new SubscriptionService(new MailchimpService(env('MAILCHIMP_API_KEY')));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
