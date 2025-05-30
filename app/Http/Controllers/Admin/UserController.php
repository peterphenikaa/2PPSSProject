<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class UserController
{
    public function user()
    {
        return view('admin.user');
    }
}
