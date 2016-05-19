<?php
namespace Savich\ApiSkeleton\Providers;

use Illuminate\Support\ServiceProvider;
use Savich\ApiSkeleton\Response\ResponseApi;
use Savich\ApiSkeleton\Response\ResponseInterface;

class ResponseServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ResponseInterface::class, function ($app) {
            return new ResponseApi();
        });
    }
}
