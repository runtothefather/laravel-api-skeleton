<?php
namespace Savich\ApiSkeleton\Response;

use Illuminate\Support\ServiceProvider;

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
