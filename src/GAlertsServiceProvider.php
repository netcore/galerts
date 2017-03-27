<?php

namespace Netcore\GAlerts;

use Illuminate\Support\ServiceProvider;

class GAlertsServiceProvider extends ServiceProvider
{

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . 'config/galerts.php' => config_path('galerts.php'),
        ], 'config');

        $this->app->singleton(Manager::class, function ($app) {
            return new Manager;
        });
    }

    /**
     * Register binding in container
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__  . '/config/galerts.php', 'galerts'
        );
    }

}