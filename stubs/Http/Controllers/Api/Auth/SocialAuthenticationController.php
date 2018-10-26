<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jijoel\AuthApi\Traits\AuthenticatesWithSocialApi;

class SocialAuthenticationController extends Controller
{
    use AuthenticatesWithSocialApi;
}
