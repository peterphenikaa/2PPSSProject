<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đặt lại Mật Khẩu</title>
    @vite('resources/css/app.css')
    @vite('resources/css/header.css')
    @vite('resources/css/footer.css')
    @vite('resources/js/app.js')
</head>

<body class="bg-gray-50">
    @include('layouts.header')

    <main class="flex items-center justify-center min-h-[calc(100vh-160px)]">
        <div class="w-full max-w-md px-6 py-8 bg-white rounded-xl shadow-lg">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Đặt lại mật khẩu</h1>
                <p class="text-sm text-gray-500">Nhập mật khẩu mới cho tài khoản của bạn</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="email" value="{{ old('email', session('reset_email')) }}">

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu mới</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            placeholder="Nhập mật khẩu mới">
                        <svg class="absolute right-3 top-3.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    @error('password')
                        <div class="text-red-600 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-1">Xác nhận mật khẩu</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password-confirm" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            placeholder="Nhập lại mật khẩu mới">
                        <svg class="absolute right-3 top-3.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-3 px-4 bg-black text-white font-medium rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors">
                    Đặt lại mật khẩu
                </button>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">hoặc</span>
                    </div>
                </div>

                <p class="text-sm text-gray-600 text-center">
                    Quay lại trang
                    <a href="/login" class="font-medium text-blue-600 hover:underline">Đăng nhập</a>
                </p>
            </form>
        </div>
    </main>

    @include('layouts.footer')
</body>

</html>