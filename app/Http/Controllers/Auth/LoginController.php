<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

class LoginController
{
    public function __construct()
    {
        
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
}
