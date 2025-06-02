<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;

class UserController
{
    public function user()
    {
        $users = User::where('role','user')->get()->map(function ($user) {
            
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => optional($user->created_at)->format('Y-m-d H:i:s'),
                'updated_at' => optional($user->updated_at)->format('Y-m-d H:i:s'),
            ];
        })->toArray();
        return view('admin.user',compact('users'));
    }
}
