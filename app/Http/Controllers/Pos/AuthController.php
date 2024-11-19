<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function showlogin()
    {
        return view('pos.auth.login');
    }
    public function showregister()
    {
        return view('pos.auth.register');
    }
}
