<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jijoel\AuthApi\Traits\AuthenticatesWithApi;

class LoginController extends Controller
{
    use AuthenticatesWithApi;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:api')->except('logout');
        $this->middleware('auth:api')->only('logout');
    }

}
