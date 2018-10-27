<?php

namespace Jijoel\AuthApi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jijoel\AuthApi\ApiAuth
 */
class ApiAuth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'api-auth';
    }

}
