<?php
namespace Savich\ApiSkeleton\Response;

use Illuminate\Support\Facades\Facade;

class ResponseApiFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return ResponseInterface::class; }

}