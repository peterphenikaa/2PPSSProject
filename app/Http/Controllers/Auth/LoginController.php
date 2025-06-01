<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class LoginController
{
    public function __construct() {}
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
            if (Auth::user()->role === 'admin') {
                //chuyển hướng đến trang quản trị nếu người dùng là admin
                //kiểm tra vai trò của người dùng
                return redirect()->intended('/admin/dashboard');
            } else {
                //nếu người dùng là người dùng thường, chuyển hướng đến trang chủ
                return redirect()->intended('/');
            }
        }
        //nếu đăng nhập không thành công, trả về trang đăng nhập với thông báo lỗi
        //và giữ lại thông tin đã nhập (email)
        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('email');
    }
}
