<?php

namespace Jijoel\AuthApi;

use Illuminate\Contracts\Routing\Registrar as Router;
use Illuminate\Support\Facades\Route;

class ApiAuth
{
    protected $router;

    /**
     * Create a new route registrar instance.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Bind the routes into the controller.
     *
     * @param  callable|null  $callback
     * @param  array  $options
     * @return void
     */
    public function routes(array $options = [])
    {
        $this->authRoutes();
        $this->registrationRoutes();
        $this->passwordRoutes();

        if (in_array('social', $options))
            $this->socialRoutes();
    }

    public function authRoutes()
    {
        Route::post('login', 'Api\Auth\LoginController@login')
            ->name('login');
        Route::post('logout', 'Api\Auth\LoginController@logout')
            ->name('logout');
    }

    public function registrationRoutes()
    {
        Route::post('register', 'Api\Auth\RegistrationController@register')
            ->name('register');
    }

    public function passwordRoutes()
    {
        Route::post('password/email', 'Api\Auth\ForgotPasswordController@sendResetLinkEmail')
            ->name('password.email');
        Route::post('password/reset', 'Api\Auth\ResetPasswordController@reset')
            ->name('password.reset');
    }

    public function socialRoutes()
    {
        Route::get('oauth/{driver}', 'Api\Auth\SocialAuthenticationController@redirectToProvider')
            ->name('oauth.redirect');
        Route::get('oauth/{driver}/callback', 'Api\Auth\SocialAuthenticationController@handleProviderCallback')
            ->name('oauth.callback');
    }

}
