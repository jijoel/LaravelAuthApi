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

    // Route::get('oauth/{driver}', 'Auth\SocialAuthenticationController@redirectToProvider')
    //     ->name('oauth.redirect');
    // Route::get('oauth/{driver}/callback', 'Auth\SocialAuthenticationController@handleProviderCallback')
    //     ->name('oauth.callback');
});

Route::group(['middleware' => 'auth:api'], function () {
//     Route::get('/user', function (Request $request) {
//         return $request->user();
//     });

    Route::post('/api/logout', 'App\Http\Controllers\Api\Auth\LoginController@logout')
        ->name('logout');
});
