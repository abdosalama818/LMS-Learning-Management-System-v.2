<?php

namespace App\Providers;

use App\Models\Stripe;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class StripeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // to fecth keys from database and put it to .env

        $stripedata = Stripe::first();
        if($stripedata){
            Config::set('stripe.stripe_pk', $stripedata->publish_key);
            Config::set('stripe.stripe_sk', $stripedata->secret_key);
        }
    }
}
