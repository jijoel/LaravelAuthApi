<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jijoel\AuthApi\Traits\AuthenticatesWithApi;

class LoginController extends Controller
{
    use AuthenticatesWithApi;
}
