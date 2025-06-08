<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sửa quản trị viên - 2PSS Sneakers Admin</title>
    @vite(['resources/css/app.css', 'resources/css/createproduct.css','resources/css/dashboard.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
</head>

<body class="bg-gray-50">
    <x-sidebar />
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header Section -->
        <header>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center text-sm text-gray-500 mb-1">
                        <a href="/admin/dashboard" class="hover:text-indigo-600 transition-colors">Dashboard</a>
                        <span class="mx-2">/</span>
                        <a href="{{ route('admin.admins') }}" class="hover:text-indigo-600 transition-colors">Quản trị viên</a>
                        <span class="mx-2">/</span>
                        <span class="text-indigo-600">Sửa quản trị viên</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-2">
                            <span class="material-icons-round text-indigo-600 bg-indigo-50 p-2 rounded-full shadow-sm">edit</span>
                            Sửa quản trị viên
                        </h1>
                    </div>
                    <p class="text-gray-500 mt-1.5 text-sm md:text-base">Chỉnh sửa thông tin tài khoản quản trị viên</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <button class="relative p-2 rounded-full hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-all shadow-sm">
                            <span class="material-icons-round">notifications</span>
                            <span class="absolute top-0 right-0 h-2.5 w-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>
                        <button class="p-2 rounded-full hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-all shadow-sm">
                            <span class="material-icons-round">help_outline</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Form Section -->
        <div class="flex justify-center">
            <div class="w-full max-w-2xl">
                <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-section">
                        <h2 class="section-title">
                            <span class="section-icon material-icons-round">person</span>
                            Thông tin tài khoản
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="form-label">Họ và tên</label>
                                <input type="text" name="name" id="name" class="form-input" placeholder="Nhập họ và tên" required value="{{ old('name', $admin->name) }}">
                            </div>

                            <div>
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-input" placeholder="Nhập địa chỉ email" required value="{{ old('email', $admin->email) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2 class="section-title">
                            <span class="section-icon material-icons-round">lock</span>
                            Thay đổi mật khẩu
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <label for="password" class="form-label">Mật khẩu mới (để trống nếu không đổi)</label>
                                <input type="password" name="password" id="password" class="form-input" placeholder="Nhập mật khẩu mới">
                            </div>

                            <div>
                                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="Nhập lại mật khẩu">
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-section">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="submit" class="btn-primary">
                                <span class="material-icons-round">save</span>
                                Lưu thay đổi
                            </button>
                            <a href="{{ route('admin.admins') }}" class="btn-secondary">
                                <span class="material-icons-round">close</span>
                                Hủy bỏ
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>