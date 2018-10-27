<?php

namespace Jijoel\AuthApi\Tests;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\Registrar as Router;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Route;
use Jijoel\AuthApi\Facades\ApiAuth as AuthFacade;
use Jijoel\AuthApi\ApiAuth;

use Orchestra\Testbench\Concerns\WithFactories;

class TestServiceProvider extends ServiceProvider
{
    use WithFactories;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->withFactories(__DIR__.'/database/factories');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->withFactories(__DIR__.'/../database/factories');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'jijoel');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/auth-api.php', 'auth-api');

        // Register the Facade
        $loader = AliasLoader::getInstance();
        $loader->alias('ApiAuth', AuthFacade::class);

        // Register the routes
        $this->app->singleton('api-auth', function ($app) {
            return new ApiAuth(app(Router::class));
        });

        // Load the routes
        Route::prefix('api')
             ->middleware('api')
             ->namespace('App\Http\Controllers')
             ->group( function() {
                AuthFacade::routes(['social']);
            });
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
}
