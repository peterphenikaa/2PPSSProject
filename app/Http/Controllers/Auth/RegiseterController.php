<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class RegiseterController
{
    public function __construct()
    {

    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    public function checkRegister(Request $request)
    {
        //Xác thực dữ liệu đầu vào từ form đăng ký
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            // phần confirmed sẽ yêu kiểm tra xem có trường password_confirmation trong form không
        ]);

        //tạo bản ghi người dùng mới trong cơ sở dữ liệu
        $user = \App\Models\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' =>Hash::make($data['password']),
        ]);

        // Sau khi đăng ký thành công, tự động đăng nhập người dùng
        Auth::login($user);
        //đánh dấu người dùng là đã đăng nhập

        return redirect('/')->with('success', 'Registration successful!');
        //Chuyển người dùng về trang chủ (/)
    }
}
