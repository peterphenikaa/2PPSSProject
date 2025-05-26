<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quên Mật Khẩu</title>
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
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Khôi phục mật khẩu</h1>
                <p class="text-sm text-gray-500">Nhập email để nhận liên kết đặt lại mật khẩu</p>
            </div>

            <div class="flex border-b border-gray-200 mb-6">
                <button class="flex-1 py-2 font-medium text-gray-500 hover:text-gray-700">
                    <a href="/login">Đăng nhập</a>
                </button>
                <button class="flex-1 py-2 font-medium text-gray-700 border-b-2 border-black">Quên mật khẩu</button>
            </div>
            <form method="POST" action="{{ route('password.request') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <input type="email" name="email" id="email" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            placeholder="Nhập email của bạn">
                        <svg class="absolute right-3 top-3.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    @error('email')
                        <div class="text-red-600 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-3 px-4 bg-black text-white font-medium rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors">
                    Gửi liên kết
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
                    Chưa có tài khoản?
                    <a href="/register" class="font-medium text-blue-600 hover:underline">Đăng ký ngay</a>
                </p>
            </form </div>
    </main>

    @include('layouts.footer')
</body>

</html>
