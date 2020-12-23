<?php

namespace App\Providers;

use App\Unsplash\Client;
use App\Unsplash\InputResolver;
use Illuminate\Support\ServiceProvider;
use Unsplash\HttpClient;


/**
 * Class UnsplashProvider
 * @package App\Providers
 *
 * @author Fabian Schilf <fabian.schilf@active-value.de>
 * @copyright 2020 active value GmbH
 */
class UnsplashProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Client::class, function ($app) {
            $credentials = config('services')['unsplash'];
            HttpClient::init([
                'applicationId' => $credentials['access_key'],
                'secret' => $credentials['secret_key'],
                'utmSource' => $credentials['application_name']
            ]);

            $inputResolver = $app->make(InputResolver::class);
            return new Client($inputResolver);
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
