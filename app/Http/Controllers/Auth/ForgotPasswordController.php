<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

class ForgotPasswordController
{
    public function __construct()
    {
        // Constructor logic if needed
    }

    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }
}
