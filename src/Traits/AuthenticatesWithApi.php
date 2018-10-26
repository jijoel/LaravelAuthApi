<?php

namespace Jijoel\AuthApi\Traits;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Hash;

trait AuthenticatesWithApi
{
    use AuthenticatesUsers;

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        // Make a standard attempt
        $attempt = $this->guard()->attempt(
            $credentials, $request->filled('remember')
        );
        if ($attempt) return $attempt;

        // If requested credentials are found,
        // but password is null, it was created via social
        $user = $this->guard()->getProvider()->retrieveByCredentials($credentials);
        if (is_null($user->password))
            $this->sendNeedSocialLoginResponse();

        return false;
    }

    /**
     * Throw an error if the user couldn't be authenticated
     * because their account was created via social media
     * and does not have a password set.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendNeedSocialLoginResponse()
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('jijoel::api-auth.social-pw')],
        ]);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        $token = $this->guard()->user()
            ->createToken('auth_token')
            ->accessToken;

        return response()->json([
            'token_type' => 'bearer',
            'token' => $token,
        ], 200);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $token = optional(auth()->user())->token();

        $token->revoke();
    }
}
