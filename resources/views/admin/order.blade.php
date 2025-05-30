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
    <div class="main-content ml-64 p-6">
        <!-- Header -->
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
                    <div class="relative hidden md:block">
                        <input type="text" placeholder="Tìm kiếm đơn hàng..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 w-64">
                        <span class="material-icons-round absolute left-3 top-2.5 text-gray-400">search</span>
                    </div>

                    <!-- Action buttons -->
                    <div class="flex items-center gap-2">
                        <!-- Notification -->
                        <button
                            class="relative p-2 rounded-full hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors">
                            <span class="material-icons-round">notifications</span>
                            <span
                                class="absolute top-0 right-0 h-2.5 w-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>

                        <!-- Help -->
                        <button
                            class="p-2 rounded-full hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors">
                            <span class="material-icons-round">help_outline</span>
                        </button>

                    </div>
                </div>
            </div>
        </header>
        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
            <div class="px-6 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Danh sách đơn hàng</h2>
                <a href="/admin/orders" class="action-link text-indigo-600">
                    Xem tất cả
                    <span class="material-icons-round ml-1">chevron_right</span>
                </a>
            </div>
            <div class="overflow-x-auto">
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
</html>
