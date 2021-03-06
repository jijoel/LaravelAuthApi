<?php

namespace Jijoel\AuthApi\Traits;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Jijoel\AuthApi\SocialAccountLoader;

trait AuthenticatesWithSocialApi
{
    /**
     * Redirect the user to the provider authentication page.
     *
     * @param  string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider(String $provider)
    {
        return [
            'url' => Socialite::driver($provider)
                ->stateless()
                ->redirect()
                ->getTargetUrl(),
        ];
    }

    /**
     * Obtain the user information from the provider.
     *
     * @param  string $driver
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(
        String $provider,
        SocialAccountLoader $loader
    ){
        $socialUser = Socialite::driver($provider)
            ->stateless()->user();

        $user = $loader->findOrCreate($socialUser, $provider);

        $token = $user
            ->createToken('auth_token')
            ->accessToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
        ], 200);
    }
}
