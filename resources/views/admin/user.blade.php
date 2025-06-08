<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard - 2PSS Sneakers</title>
    @vite(['resources/css/app.css', 'resources/css/order.css', 'resources/css/dashboard.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
</head>

<body>
    <x-sidebar />
    <div class="main-content ml-64 p-6 ">
        <header class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center text-sm text-gray-500 mb-1">
                        <a href="/admin/dashboard" class="hover:text-indigo-600">Dashboard</a>
                        <span class="mx-2">/</span>
                        <span class="text-indigo-600">Khách Hàng</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-2">
                        <span class="material-icons-round text-indigo-600">group</span>
                        Quản lý khách hàng
                    </h1>
                    <p class="text-gray-600 mt-1 text-sm md:text-base">Xem và quản lý tất cả khách hàng của cửa hàng</p>
                </div>
                <div class="flex items-center gap-4">
                    <form action="{{ route('admin.users.search') }}" method="GET" class="relative hidden md:block">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm khách hàng..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 w-64">
                        <span class="material-icons-round absolute left-3 top-2.5 text-gray-400">search</span>
                    </form>
                    <div class="flex items-center gap-2">
                        <button id="helpBtn" type="button"
                            class="p-2 rounded-full hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors">
                            <span class="material-icons-round">help_outline</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>
        <!-- Modal hướng dẫn sử dụng -->
        <div id="helpModal" class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-40"
            style="display:none;">
            <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6 relative animate-fade-in mx-auto mt-24">
                <button id="closeHelpModal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700">
                    <span class="material-icons-round">close</span>
                </button>
                <h2 class="text-xl font-bold mb-2 text-indigo-700 flex items-center gap-2">
                    <span class="material-icons-round">help_outline</span> Hướng dẫn sử dụng
                </h2>
                <ul class="list-disc pl-5 text-gray-700 space-y-1 mb-2">
                    <li>Tìm kiếm khách hàng theo tên, email hoặc ID bằng ô tìm kiếm phía trên.</li>
                    <li>Nhấn nút <span class="material-icons-round text-sm align-middle">edit</span> để sửa thông tin khách hàng.</li>
                    <li>Nhấn nút <span class="material-icons-round text-sm align-middle text-red-600">delete</span> để xóa khách hàng (cần xác nhận).</li>
                    <li>Cột STT là số thứ tự hiển thị, không phải ID trong database.</li>
                </ul>
                <div class="text-gray-500 text-sm mt-2">
                    Nếu cần hỗ trợ thêm, vui lòng liên hệ quản trị viên hệ thống.<br>
                    <span class="font-semibold">Hotline:</span> 0123 456 789<br>
                    <span class="font-semibold">Email:</span> support@2pss.vn
                </div>
            </div>
        </div>
        <script>
            const helpBtn = document.getElementById('helpBtn');
            const helpModal = document.getElementById('helpModal');
            const closeHelpModal = document.getElementById('closeHelpModal');
            helpBtn.addEventListener('click', () => helpModal.style.display = 'flex');
            closeHelpModal.addEventListener('click', () => helpModal.style.display = 'none');
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') helpModal.style.display = 'none';
            });
        </script>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200 mt-4">
            <div class="px-6 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Danh sách người dùng</h2>
            </div>
            <div class="overflow-x-auto" style="max-height: 70vh; overflow-y: auto;">
                <table class="order-table w-full">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="px-4 py-2 text-left">STT</th>
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Tên</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Ngày tạo</th>
                            <th class="px-4 py-2 text-left">Cập nhật gần nhất</th>
                            <th class="px-4 py-2 text-left">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 font-medium text-gray-900">
                                    #{{ str_pad($user['id'], 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-4 py-2">{{ $user['name'] }}</td>
                                <td class="px-4 py-2">{{ $user['email'] }}</td>
                                <td class="px-4 py-2">{{ $user['created_at'] }}</td>
                                <td class="px-4 py-2">{{ $user['updated_at'] }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.users.edit', $user['id']) }}"
                                        class="text-indigo-600 hover:text-indigo-800 mr-2">
                                        <span class="material-icons-round">edit</span>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user['id']) }}" method="POST"
                                        style="display:inline-block"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <span class="material-icons-round">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if (empty($users))
                <div class="p-8 text-center text-gray-500">
                    <span class="material-icons-round text-4xl mb-2 text-gray-300">receipt_long</span>
                    <p>Không có khách hàng nào gần đây</p>
                </div>
            @endif
        </div>

    </div>
</body>

</html>
