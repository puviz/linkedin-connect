<?php

namespace Puviz\LinkedInConnect\Facades;

use Illuminate\Support\Facades\Facade;
use Puviz\LinkedInConnect\Contracts\LinkedInConnect as LinkedInConnectContract;

/**
 * @see \Puviz\LinkedInConnect\Contracts\LinkedInConnect
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
        return LinkedInConnectContract::class;
    }
}
