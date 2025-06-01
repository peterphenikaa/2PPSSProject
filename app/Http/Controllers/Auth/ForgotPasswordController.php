<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function __construct()
    {
        // Có thể thêm middleware nếu muốn
        
    }

    // Hiển thị form nhập email
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }
    public function showResetPassword()
    {
        return view('auth.reset-password');
    }
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Kiểm tra email có tồn tại trong cơ sở dữ liệu không
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            //nêu không tìm thấy người dùng với email này
            // thì trả về trang trước với thông báo lỗi
            // và không thực hiện gửi email reset mật khẩu
            return back()->withErrors(['email' => 'Email bạn vừa nhập không tồn tại']);
        }
        session(['reset_email' => $request->email]);
        return redirect()->intended('/reset-password')
            ->with('status', 'Chúng tôi đã gửi liên kết đặt lại mật khẩu đến email của bạn.');
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $email = session('reset_email'); 

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect('/forgot-password')->withErrors(['email' => 'Không tìm thấy người dùng.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        session()->forget('reset_email'); 

        return redirect('/login')->with('status', 'Mật khẩu đã được cập nhật thành công.');
    }
}
