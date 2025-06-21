<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa tài khoản khách hàng</title>
    @vite(['resources/css/app.css', 'resources/css/dashboard.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
</head>
<body>
    <x-sidebar />
    <div class="main-content ml-64 p-6 ">
        <header class="mb-8 shadow-md bg-white rounded-xl px-6 py-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center text-sm text-gray-500 mb-1">
                        <a href="/admin/dashboard" class="hover:text-indigo-600">Dashboard</a>
                        <span class="mx-2">/</span>
                        <a href="{{ route('admin.user') }}" class="hover:text-indigo-600">Khách Hàng</a>
                        <span class="mx-2">/</span>
                        <span class="text-indigo-600">Sửa tài khoản</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-2">
                        <span class="material-icons-round text-indigo-600">edit</span>
                        Sửa tài khoản khách hàng
                    </h1>
                    <p class="text-gray-600 mt-1 text-sm md:text-base">Chỉnh sửa thông tin khách hàng</p>
                </div>
            </div>
        </header>
        <div class="flex justify-center items-center min-h-[60vh]">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 w-full max-w-lg p-8">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block mb-1 font-semibold">Tên</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500" required>
                    </div>
                    <div>
                        <label for="email" class="block mb-1 font-semibold">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500" required>
                    </div>
                    <div class="mt-4">
                        <label for="password" class="block mb-1 font-semibold">Mật khẩu mới (bỏ trống nếu không đổi)</label>
                        <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500">
                    </div>
                    <div class="mt-4">
                        <label for="password_confirmation" class="block mb-1 font-semibold">Xác nhận mật khẩu mới</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500">
                    </div>
                    <div class="flex gap-2 mt-6">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-semibold transition-colors">Lưu</button>
                        <a href="{{ route('admin.user') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg font-semibold transition-colors">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
