<?php

namespace Puviz\LinkedInConnect;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Puviz\LinkedInConnect\Contracts\LinkedInConnect as LinkedInConnectContract;

class LinkedInServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LinkedInConnectContract::class, function () {
            return new LinkedInConnect();
        });
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->mergeConfigFrom(__DIR__ . '/../config/linkedin.php', 'linkedin');

        if ($this->app->runningInConsole()) {
            $this->registerMigrations();

            $this->registerRoutes();

            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'linkedin-connect-migrations');

            $this->publishes([
                __DIR__ . '/../config/linkedin.php' => config_path('linkedin.php'),
            ], 'linkedin-connect-config');

        }
    }

    /**
     * Register LinkedInConnect's migration files.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Register LinkedInConnect's routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('linkedin.route.prefix'),
            'middleware' => config('linkedin.route.middleware'),
        ];
    }
}
