<?php

namespace Jijoel\AuthApi;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Contracts\Routing\Registrar as Router;
use Jijoel\AuthApi\Facades\ApiAuth as AuthFacade;

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
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadBladeConfigDirective();

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

        // Register the Facade
        $loader = AliasLoader::getInstance();
        $loader->alias('ApiAuth', AuthFacade::class);

        // Register the routes
        $this->app->singleton('api-auth', function ($app) {
            return new ApiAuth(app(Router::class));
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

    /**
     * Define an @config directive for Blade files
     *
     * @return String   text generated for @config
     */
    public function loadBladeConfigDirective()
    {
        $this->app['blade.compiler']->directive('config', function ($attrs) {
            return "<?php echo app('"
                . config('auth-api.config-class', BladeConfigGenerator::class)
                . "')->generate({$attrs}); ?>";
        });
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        $this->publishes([
            __DIR__.'/../config/auth-api.php' => config_path('auth-api.php'),
        ], 'auth-api.config');

        $this->publishes([
            __DIR__.'/../database/factories' => database_path('factories'),
        ], 'auth-api.factories');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'auth-api.migrations');

        // Publishing the translation files.
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/jijoel'),
        ], 'auth-api.lang');

        // Registering package commands.
        $this->commands([
            Console\MakeAuthCommand::class,
            Console\MakeJsCommand::class,
        ]);
    }

}
