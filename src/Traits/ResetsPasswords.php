<?php

namespace Jijoel\AuthApi\Traits;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords as Base;
use Illuminate\Validation\ValidationException;

trait ResetsPasswords
{
    use Base;

    /**
     * Get the response for a successful password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {
        return ['status' => trans($response)];
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string  $response
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        throw ValidationException::withMessages([
            'email' => trans($response)
        ]);
    }
}
