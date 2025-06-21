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
                    <div class="relative flex items-center gap-2">
                        <button id="helpBtnUser" type="button"
                            class="p-2 rounded-full hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors"
                            style="cursor:pointer">
                            <span class="material-icons-round">help_outline</span>
                        </button>
                        <!-- Popover hướng dẫn sử dụng -->
                        <div id="helpPopoverUser" class="hidden absolute top-full right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 p-4 z-50">
                            <h3 class="text-md font-bold mb-2 text-indigo-700 flex items-center gap-2">
                                <span class="material-icons-round">help_outline</span> Hướng dẫn sử dụng
                            </h3>
                            <ul class="list-disc pl-5 text-gray-700 space-y-1 text-sm">
                                <li>Tìm kiếm khách hàng theo tên, email hoặc ID.</li>
                                <li>Nhấn nút <span class="material-icons-round text-sm align-middle">edit</span> để sửa vai trò.</li>
                                <li>Nhấn nút <span class="material-icons-round text-sm align-middle text-red-600">delete</span> để xóa người dùng.</li>
                            </ul>
                            <div class="text-gray-500 text-xs mt-3 border-t pt-2">
                                Cần hỗ trợ? Liên hệ <span class="font-semibold">support@2pss.vn</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
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
                        @forelse ($users as $key => $user)
                            <tr>
                                <td>{{ $users->firstItem() + $key }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="text-indigo-600 hover:text-indigo-800 transition-colors">
                                        <span class="material-icons-round">edit</span>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 transition-colors">
                                            <span class="material-icons-round">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                    Không có khách hàng nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>

    </div>
    <script>
        const helpBtnUser = document.getElementById('helpBtnUser');
        const helpPopoverUser = document.getElementById('helpPopoverUser');

        if (helpBtnUser && helpPopoverUser) {
            helpBtnUser.addEventListener('click', (event) => {
                event.stopPropagation();
                helpPopoverUser.classList.toggle('hidden');
            });

            document.addEventListener('click', (event) => {
                if (!helpPopoverUser.contains(event.target) && !helpBtnUser.contains(event.target)) {
                    helpPopoverUser.classList.add('hidden');
                }
            });

            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    helpPopoverUser.classList.add('hidden');
                }
            });
        }
    </script>
</body>

</html>
