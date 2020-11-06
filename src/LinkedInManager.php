<?php

namespace Puviz\LinkedInConnect;

use Illuminate\Support\Arr;
use Illuminate\Support\Manager;
use Illuminate\Support\Str;
use InvalidArgumentException;

class LinkedInManager extends Manager implements Contracts\Factory
{
    /**
     * Get a driver instance.
     *
     * @param string $driver
     * @return mixed
     */
    public function with(string $driver)
    {
        return $this->driver($driver);
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Puviz\LinkedInConnect\AbstractProvider
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function createLinkedinDriver()
    {
        $config = $this->config->get('linkedin.linkedin_access_client');

        return $this->buildProvider(
          LinkedInProvider::class, $config
        );
    }

    /**
     * Build an OAuth 2 provider instance.
     *
     * @param string $provider
     * @param array $config
     * @return \Puviz\LinkedInConnect\AbstractProvider
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function buildProvider(string $provider, array $config)
    {
        return new $provider(
            $this->container->make('request'), $config['client_id'],
            $config['client_secret'], $this->formatRedirectUrl($config),
            Arr::get($config, 'guzzle', [])
        );
    }

    /**
     * Format the callback URL, resolving a relative URI if needed.
     *
     * @param array $config
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function formatRedirectUrl(array $config)
    {
        $redirect = value($config['redirect']);

        return Str::startsWith($redirect, '/')
                    ? $this->container->make('url')->to($redirect)
                    : $redirect;
    }

    /**
     * Get the default driver name.
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function getDefaultDriver()
    {
        throw new InvalidArgumentException('No Socialite driver was specified.');
    }
}
