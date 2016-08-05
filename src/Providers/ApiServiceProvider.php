<?php
namespace Savich\ApiSkeleton\Providers;

use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\Providers\JWTAuthServiceProvider;
use Savich\ApiSkeleton\Response\ResponseApiFacade;
use Illuminate\Foundation\AliasLoader;

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

        $loader = AliasLoader::getInstance();
        $loader->alias('ResponseApi', ResponseApiFacade::class);
        $loader->alias('JWTAuth', \Tymon\JWTAuth\Facades\JWTAuth::class);
        $loader->alias('JWTFactory', \Tymon\JWTAuth\Facades\JWTFactory::class);
    }
}