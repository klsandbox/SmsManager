<?php

namespace Klsandbox\SmsManager;

use Illuminate\Support\ServiceProvider;

class SmsManagerServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('command.klsandbox.smstopup', function($app) {
            return new SmsTopUp();
        });

        $this->commands('command.klsandbox.smstopup');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return [
            'command.klsandbox.smstopup',
        ];
    }

    public function boot() {
        $this->publishes([
            __DIR__ . '/../../../database/migrations/' => database_path('/migrations')
                ], 'migrations');

        $this->publishes([
            __DIR__ . '/../../../config/' => config_path()
                ], 'config');

        $this->loadViewsFrom(
                __DIR__ . '/../../../views/', 'sms-manager');

        $this->publishes([
            __DIR__ . '/../../../views/' => base_path('resources/views/vendor/sms-manager'),
        ]);
    }

}
