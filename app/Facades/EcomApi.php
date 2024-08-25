<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * EcomApi Facade
 */
class EcomApi extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'EcomApi';
    }
}
