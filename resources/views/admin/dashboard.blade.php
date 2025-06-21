<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - 2PSS Sneakers</title>
    @vite('resources/css/app.css')
    @vite('resources/css/dashboard.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
    <x-sidebar />

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-800">Tổng quan hệ thống</h1>
                <div class="flex items-center space-x-4">
                    <form action="/admin/search" method="GET" class="relative">
                        <input type="text" name="query" placeholder="Tìm kiếm..." class="pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:border-indigo-500">
                        <button type="submit" class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-500">
                            <span class="material-icons-round">search</span>
                        </button>
                    </form>
                    <div class="relative flex items-center gap-2">
                        <button id="helpBtnDashboard" type="button" class="p-2 rounded-full hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors">
                            <span class="material-icons-round">help_outline</span>
                        </button>
                        <!-- Popover hướng dẫn sử dụng -->
                        <div id="helpPopoverDashboard" class="hidden absolute top-full right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 p-4 z-50">
                            <h3 class="text-md font-bold mb-2 text-indigo-700 flex items-center gap-2">
                                <span class="material-icons-round">help_outline</span> Hướng dẫn sử dụng
                            </h3>
                            <ul class="list-disc pl-5 text-gray-700 space-y-1 text-sm">
                                <li>Đây là trang tổng quan hiển thị các số liệu chính.</li>
                                <li>Các biểu đồ thể hiện doanh thu và đơn hàng theo thời gian.</li>
                                <li>Bảng "Sản phẩm bán chạy" liệt kê các sản phẩm có doanh thu cao nhất.</li>
                            </ul>
                            <div class="text-gray-500 text-xs mt-3 border-t pt-2">
                                Cần hỗ trợ? Liên hệ <span class="font-semibold">support@2pss.vn</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="content-wrapper">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card">
                    <h2 class="text-sm text-gray-500 font-medium uppercase tracking-wider">Tổng đơn hàng</h2>
                    <div class="text-3xl font-bold text-indigo-600 mt-2">{{ $orderCount }}</div>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <span class="material-icons-round text-green-500 mr-1">trending_up</span>
                        <span>12% so với tháng trước</span>
                    </div>
                </div>
                <div class="stat-card">
                    <h2 class="text-sm text-gray-500 font-medium uppercase tracking-wider">Doanh thu tháng</h2>
                    <div class="text-3xl font-bold text-emerald-600 mt-2">₫{{ number_format($monthlyRevenue) }}</div>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <span class="material-icons-round text-green-500 mr-1">trending_up</span>
                        <span>8.5% so với tháng trước</span>
                    </div>
                </div>
                <div class="stat-card">
                    <h2 class="text-sm text-gray-500 font-medium uppercase tracking-wider">Tổng sản phẩm</h2>
                    <div class="text-3xl font-bold text-blue-600 mt-2">{{ $productCount }}</div>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <span class="material-icons-round text-green-500 mr-1">inventory_2</span>
                        <span>5 sản phẩm mới</span>
                    </div>
                </div>
                <div class="stat-card">
                    <h2 class="text-sm text-gray-500 font-medium uppercase tracking-wider">Khách hàng</h2>
                    <div class="text-3xl font-bold text-orange-500 mt-2">{{ $customerCount }}</div>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <span class="material-icons-round text-green-500 mr-1">group_add</span>
                        <span>24 khách hàng mới</span>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="lg:col-span-2 stat-card">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-gray-800">Doanh thu 6 tháng gần nhất</h2>
                    </div>
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
                <div class="stat-card">
                    <h2 class="text-lg font-semibold text-gray-800 mb-6">Phân loại đơn hàng</h2>
                    <div class="chart-container">
                        <canvas id="orderStatusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="px-6 py-4 flex items-center justify-between border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-800">Đơn hàng gần đây</h2>
                    <a href="/admin/orders" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center">
                        Xem tất cả
                        <span class="material-icons-round ml-1 text-base">chevron_right</span>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>Mã ĐH</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Ngày đặt</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr>
                                <td class="font-medium text-gray-900">#{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>₫{{ number_format($order->total_price) }}</td>
                                <td>
                                    <span class="status-badge {{
                                        $order->status === 'Đã giao' ? 'bg-green-100 text-green-800' :
                                        ($order->status === 'Đang giao' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')
                                    }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at ? $order->created_at->format('d/m/Y') : 'Chưa có' }}</td>
                                <td class="text-right">
                                    <a href="/admin/orders/{{ $order->id }}" class="text-indigo-600 hover:text-indigo-900 font-medium flex items-center justify-end">
                                        Chi tiết
                                        <span class="material-icons-round ml-1 text-base">chevron_right</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Popover logic
        const helpBtnDashboard = document.getElementById('helpBtnDashboard');
        const helpPopoverDashboard = document.getElementById('helpPopoverDashboard');

        if (helpBtnDashboard && helpPopoverDashboard) {
            helpBtnDashboard.addEventListener('click', (event) => {
                event.stopPropagation();
                helpPopoverDashboard.classList.toggle('hidden');
            });

            document.addEventListener('click', (event) => {
                if (!helpPopoverDashboard.contains(event.target) && !helpBtnDashboard.contains(event.target)) {
                    helpPopoverDashboard.classList.add('hidden');
                }
            });

            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    helpPopoverDashboard.classList.add('hidden');
                }
            });
        }

        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($revenueLabels) !!},
                datasets: [{
                    label: 'Doanh thu',
                    data: {!! json_encode($revenueData) !!},
                    backgroundColor: 'rgba(79, 70, 229, 0.8)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Order Status Chart
        const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
        new Chart(orderStatusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($statusLabels) !!},
                datasets: [{
                    data: {!! json_encode($statusData) !!},
                    backgroundColor: [
                        '#10b981', // Đã giao
                        '#f59e0b', // Đang giao hàng
                        '#ef4444', // Đã hủy
                        '#94a3b8', // Chờ xác nhận
                    ],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 20
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>