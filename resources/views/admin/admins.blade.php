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
                        <span class="text-indigo-600">Quản Trị Viên</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-2">
                        <span class="material-icons-round text-indigo-600">admin_panel_settings</span>
                        Quản trị viên
                    </h1>
                    <p class="text-gray-600 mt-1 text-sm md:text-base">Xem và quản lý tất cả quản trị viên của cửa hàng
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <button id="helpBtnAdmin" type="button"
                            class="p-2 rounded-full hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors"
                            style="cursor:pointer">
                            <span class="material-icons-round">help_outline</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>
        <!-- Modal hướng dẫn sử dụng -->
        <div id="helpModalAdmin"
            class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-40"
            style="display:none;">
            <div
                class="bg-white rounded-xl shadow-lg max-w-md w-full p-6 relative animate-fade-in mx-auto mt-24">
                <button id="closeHelpModalAdmin"
                    class="absolute top-2 right-2 text-gray-400 hover:text-gray-700">
                    <span class="material-icons-round">close</span>
                </button>
                <h2 class="text-xl font-bold mb-2 text-indigo-700 flex items-center gap-2">
                    <span class="material-icons-round">help_outline</span> Hướng dẫn sử dụng
                </h2>
                <ul class="list-disc pl-5 text-gray-700 space-y-1 mb-2">
                    <li>Xem danh sách quản trị viên, thông tin chi tiết từng admin.</li>
                    <li>Nhấn nút <span class="material-icons-round text-sm align-middle">edit</span> để sửa thông tin
                        admin.</li>
                    <li>Nhấn nút <span class="material-icons-round text-sm align-middle text-red-600">delete</span>
                        để xóa admin (cần xác nhận).</li>
                    <li>Chỉ nên xóa admin khi chắc chắn, tránh xóa nhầm tài khoản quản trị.</li>
                </ul>
                <div class="text-gray-500 text-sm mt-2">
                    Nếu cần hỗ trợ thêm, vui lòng liên hệ quản trị viên hệ thống.<br>
                    <span class="font-semibold">Hotline:</span> 0123 456 789<br>
                    <span class="font-semibold">Email:</span> support@2pss.vn
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200 mt-4">
            <div class="px-6 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Danh sách quản trị viên</h2>
            </div>
            <div class="overflow-x-auto" style="max-height: 70vh; overflow-y: auto;">
                <table class="order-table w-full">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Tên</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Ngày tạo</th>
                            <th class="px-4 py-2 text-left">Cập nhật gần nhất</th>
                            <th class="px-4 py-2 text-left">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2 font-medium text-gray-900">
                                    #{{ str_pad($admin['id'], 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-4 py-2">{{ $admin['name'] }}</td>
                                <td class="px-4 py-2">{{ $admin['email'] }}</td>
                                <td class="px-4 py-2">{{ $admin['created_at'] }}</td>
                                <td class="px-4 py-2">{{ $admin['updated_at'] }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.admins.edit', $admin['id']) }}"
                                        class="text-indigo-600 hover:text-indigo-800 mr-2">
                                        <span class="material-icons-round">edit</span>
                                    </a>
                                    <!-- Xóa admin đã bị loại bỏ -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if (empty($admins))
                <div class="p-8 text-center text-gray-500">
                    <span class="material-icons-round text-4xl mb-2 text-gray-300">receipt_long</span>
                    <p>Không có quản trị viên nào</p>
                </div>
            @endif
        </div>

    </div>
    <script>
        const helpBtnAdmin = document.getElementById('helpBtnAdmin');
        const helpModalAdmin = document.getElementById('helpModalAdmin');
        const closeHelpModalAdmin = document.getElementById('closeHelpModalAdmin');
        if (helpBtnAdmin && helpModalAdmin && closeHelpModalAdmin) {
            helpBtnAdmin.addEventListener('click', () => helpModalAdmin.style.display = 'flex');
            closeHelpModalAdmin.addEventListener('click', () => helpModalAdmin.style.display = 'none');
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') helpModalAdmin.style.display = 'none';
            });
        }
    </script>
</body>

</html>
