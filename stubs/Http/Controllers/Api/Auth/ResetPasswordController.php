<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jijoel\AuthApi\Traits\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;
}
