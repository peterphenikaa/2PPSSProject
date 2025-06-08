<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - 2PSS Sneakers</title>
    @vite(['resources/css/app.css', 'resources/css/order.css', 'resources/css/dashboard.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
</head>

<body class="bg-white font-sans">
    <x-sidebar />

    <!-- Main Content -->
    <div class="main-content ml-64 p-6 ">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <!-- Page title and breadcrumb -->
                <div>
                    <div class="flex items-center text-sm text-gray-500 mb-1">
                        <a href="/admin/dashboard" class="hover:text-indigo-600">Dashboard</a>
                        <span class="mx-2">/</span>
                        <span class="text-indigo-600">Đơn hàng</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-2">
                        <span class="material-icons-round text-indigo-600">receipt_long</span>
                        Quản lý đơn hàng
                    </h1>
                    <p class="text-gray-600 mt-1 text-sm md:text-base">Xem và quản lý tất cả đơn hàng của cửa hàng</p>
                </div>

                <!-- Action buttons and user menu -->
                <div class="flex items-center gap-4">
                    <!-- Search bar -->
                    <form action="{{ route('admin.orders.search') }}" method="GET" class="relative hidden md:block">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm đơn hàng..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 w-64">
                        <span class="material-icons-round absolute left-3 top-2.5 text-gray-400">search</span>
                    </form>

                    <!-- Action buttons -->
                    <div class="flex items-center gap-2">
                        <!-- Help -->
                        <button id="helpBtnOrder" type="button"
                            class="p-2 rounded-full hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors">
                            <span class="material-icons-round">help_outline</span>
                        </button>

                    </div>
                </div>
            </div>
        </header>
        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200 mt-4">
            <div class="px-6 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Danh sách đơn hàng</h2>
                <a href="/admin/orders" class="action-link text-indigo-600">
                    Xem tất cả
                    <span class="material-icons-round ml-1">chevron_right</span>
                </a>
            </div>
            <div class="overflow-x-auto" style="max-height: 70vh; overflow-y: auto;">
                <table class="order-table">
                    <thead>
                        <tr>
                            <th class="w-24">Mã ĐH</th>
                            <th>Khách hàng</th>
                            <th>Sản phẩm</th>
                            <th class="w-40">Tổng tiền</th>
                            <th class="w-40">Trạng thái</th>
                            <th class="w-40">Ngày đặt</th>
                            <th class="w-32"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentOrders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="font-medium text-gray-900">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                </td>

                                <td>{{ $order->user->name }}</td>

                                <!-- Tên sản phẩm -->
                                <td>
                                    <ul class="text-sm text-gray-600 list-disc list-inside">
                                        @foreach ($order->orderItems as $item)
                                            <li>{{ $item->product->name ?? 'Không rõ' }}</li>
                                        @endforeach
                                    </ul>
                                </td>

                                <td class="font-medium">₫{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td>
                                    <span
                                        class="status-badge 
                                        {{ $order->status === 'Đã giao'
                                            ? 'bg-green-100 text-green-800'
                                            : ($order->status === 'Đang giao'
                                                ? 'bg-yellow-100 text-yellow-800'
                                                : 'bg-red-100 text-red-800') }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-right">
                                    <a href="/admin/orders/{{ $order->id }}" class="action-link text-indigo-600">
                                        Chi tiết
                                        <span class="material-icons-round ml-1">chevron_right</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($recentOrders->isEmpty())
                <div class="p-8 text-center text-gray-500">
                    <span class="material-icons-round text-4xl mb-2 text-gray-300">receipt_long</span>
                    <p>Không có đơn hàng nào gần đây</p>
                </div>
            @endif
        </div>
    </div>
</body>

<!-- Modal hướng dẫn sử dụng -->
<div id="helpModalOrder" class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-40"
    style="display:none;">
    <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6 relative animate-fade-in mx-auto mt-24">
        <button id="closeHelpModalOrder" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700">
            <span class="material-icons-round">close</span>
        </button>
        <h2 class="text-xl font-bold mb-2 text-indigo-700 flex items-center gap-2">
            <span class="material-icons-round">help_outline</span> Hướng dẫn sử dụng
        </h2>
        <ul class="list-disc pl-5 text-gray-700 space-y-1 mb-2">
            <li>Tìm kiếm đơn hàng theo mã, tên khách, email hoặc trạng thái bằng ô tìm kiếm phía trên.</li>
            <li>Nhấn vào mã đơn hàng để xem chi tiết đơn hàng.</li>
            <li>Trạng thái đơn hàng được hiển thị màu sắc khác nhau để dễ phân biệt.</li>
        </ul>
        <div class="text-gray-500 text-sm mt-2">
            Nếu cần hỗ trợ thêm, vui lòng liên hệ quản trị viên hệ thống.<br>
            <span class="font-semibold">Hotline:</span> 0123 456 789<br>
            <span class="font-semibold">Email:</span> support@2pss.vn
        </div>
    </div>
</div>

<script>
    const helpBtnOrder = document.getElementById('helpBtnOrder');
    const helpModalOrder = document.getElementById('helpModalOrder');
    const closeHelpModalOrder = document.getElementById('closeHelpModalOrder');
    helpBtnOrder.addEventListener('click', () => helpModalOrder.style.display = 'flex');
    closeHelpModalOrder.addEventListener('click', () => helpModalOrder.style.display = 'none');
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') helpModalOrder.style.display = 'none';
    });
</script>

</html>
