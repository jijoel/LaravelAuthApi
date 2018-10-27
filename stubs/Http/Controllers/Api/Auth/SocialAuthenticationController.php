<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jijoel\AuthApi\Traits\AuthenticatesWithSocialApi;

class SocialAuthenticationController extends Controller
{
    use AuthenticatesWithSocialApi;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('guest:api');
    }

}
