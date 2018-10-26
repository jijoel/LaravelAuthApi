<?php

use Illuminate\Http\Request;

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('/api/login', 'App\Http\Controllers\Api\Auth\LoginController@login')
        ->name('login');
    Route::post('/api/register', 'App\Http\Controllers\Api\Auth\RegistrationController@register')
        ->name('register');
    Route::post('/api/password/email', 'App\Http\Controllers\Api\Auth\ForgotPasswordController@sendResetLinkEmail')
        ->name('password.email');
    Route::post('/api/password/reset', 'App\Http\Controllers\Api\Auth\ResetPasswordController@reset')
        ->name('password.reset');

    Route::get('/api/oauth/{driver}', 'App\Http\Controllers\Api\Auth\SocialAuthenticationController@redirectToProvider')
        ->name('oauth.redirect');
    Route::get('/api/oauth/{driver}/callback', 'App\Http\Controllers\Api\Auth\SocialAuthenticationController@handleProviderCallback')
        ->name('oauth.callback');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/api/logout', 'App\Http\Controllers\Api\Auth\LoginController@logout')
        ->name('logout');
});
