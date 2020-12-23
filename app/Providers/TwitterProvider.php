<?php

namespace App\Providers;

use App\Twitter\Client;
use Illuminate\Support\ServiceProvider;

/**
 * Class TwitterProvider
 * @package App\Providers
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class TwitterProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Client::class, function ($app) {
            $twitterConfig = config('services')['twitter'];
            $guzzleClient = new \GuzzleHttp\Client([
                'base_uri' => 'https://api.twitter.com',
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $twitterConfig['bearer_token']
                ]
            ]);

            return new Client($guzzleClient);
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
