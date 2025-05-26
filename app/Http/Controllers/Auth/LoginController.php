<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function __construct()
    {
        
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function checkLogin(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();
        //nếu đăng nhập thành công, tạo lại session để bảo mật
        return redirect()->intended('/');
        //đưa người dùng tới URL họ định truy cập trước khi bị yêu cầu đăng nhập (nếu có)
        //Nếu không có thì chuyển về /
    }
    //nếu đăng nhập không thành công, trả về trang đăng nhập với thông báo lỗi
    //và giữ lại thông tin đã nhập (email)
    return back()->withErrors([
        'email' => 'Thông tin đăng nhập không chính xác.',
    ])->onlyInput('email');
}
}
