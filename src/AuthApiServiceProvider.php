<?php

namespace Jijoel\AuthApi;

use Illuminate\Support\ServiceProvider;

class AuthApiServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'jijoel');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'jijoel');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/auth-api.php', 'auth-api');

        // Register the service the package provides.
        // $this->app->singleton('laravel-auth-api', function ($app) {
        //     return new LaravelAuthApi;
        // });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['auth-api'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/auth-api.php' => config_path('auth-api.php'),
        ], 'auth-api.config');

        $this->registerMigrations();

        // $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/jijoel'),
        ], 'auth-api.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/jijoel'),
        ], 'auth-api.assets');*/

        // Publishing the translation files.
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/jijoel'),
        ], 'auth-api.lang');

        // Registering package commands.
        // $this->commands([
        //     Console\InstallCommand::class,
        //     Console\ClientCommand::class,
        //     Console\KeysCommand::class,
        // ]);
    }

    /**
     * Register our migration files.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        return $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'auth-api.migrations');
    }

}
