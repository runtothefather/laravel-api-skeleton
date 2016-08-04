<?php
namespace Savich\ApiSkeleton\Providers;

use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\Providers\JWTAuthServiceProvider;

class ApiServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(ResponseServiceProvider::class);
        $this->app->register(JWTAuthServiceProvider::class);
        $this->app->register(ApiEventServiceProvider::class);
    }
}