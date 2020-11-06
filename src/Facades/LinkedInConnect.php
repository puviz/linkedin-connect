<?php

namespace Puviz\LinkedInConnect\Facades;

use Illuminate\Support\Facades\Facade;
use Puviz\LinkedInConnect\Contracts\Factory;

/**
 * @method static \Puviz\LinkedInConnect\Contracts\Provider driver(string $driver = null)
 * @see \Puviz\LinkedInConnect\LinkedInManager
 */
class LinkedInConnect extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}
