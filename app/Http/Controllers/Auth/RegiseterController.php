<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

class RegiseterController
{
    public function __construct()
    {
        // Constructor logic if needed
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }
}
