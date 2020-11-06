<?php

namespace Puviz\LinkedInConnect\Contracts;

interface Factory
{
    /**
     * Get an OAuth provider implementation.
     *
     * @param string $driver
     * @return \Puviz\LinkedInConnect\Contracts\Provider
     */
    public function driver($driver = null);
}
