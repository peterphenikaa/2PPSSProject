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
                    <button id="helpBtnDashboard" type="button" class="p-2 rounded-full hover:bg-gray-100" style="cursor:pointer">
                        <span class="material-icons-round">help_outline</span>
                    </button>
                </div>
            </div>
        </header>

        <!-- Modal hướng dẫn sử dụng -->
        <div id="helpModalDashboard" class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-40" style="display:none;">
            <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6 relative animate-fade-in mx-auto mt-24">
                <button id="closeHelpModalDashboard" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700">
                    <span class="material-icons-round">close</span>
                </button>
                <h2 class="text-xl font-bold mb-2 text-indigo-700 flex items-center gap-2">
                    <span class="material-icons-round">help_outline</span> Hướng dẫn sử dụng Dashboard
                </h2>
                <ul class="list-disc pl-5 text-gray-700 space-y-1 mb-2">
                    <li>Xem tổng quan số lượng đơn hàng, doanh thu, sản phẩm, khách hàng ở các thẻ thống kê phía trên.</li>
                    <li>Xem biểu đồ doanh thu và phân loại đơn hàng ở phần biểu đồ.</li>
                    <li>Xem danh sách đơn hàng gần đây ở cuối trang, nhấn "Chi tiết" để xem thông tin đơn hàng.</li>
                    <li>Có thể truy cập nhanh các trang quản lý khác qua sidebar bên trái.</li>
                </ul>
                <div class="text-gray-500 text-sm mt-2">
                    Nếu cần hỗ trợ thêm, vui lòng liên hệ quản trị viên hệ thống.<br>
                    <span class="font-semibold">Hotline:</span> 0123 456 789<br>
                    <span class="font-semibold">Email:</span> support@2pss.vn
                </div>
            </div>
        </div>

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
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($revenueLabels) !!},
                datasets: [{
                    label: 'Doanh thu (VND)',
                    data: {!! json_encode($revenueData) !!},
                    backgroundColor: '#6366f1',
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '₫' + context.raw.toLocaleString('vi-VN');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                        },
                        ticks: {
                            callback: function(value) {
                                return '₫' + value.toLocaleString('vi-VN');
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        }
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

        const helpBtnDashboard = document.getElementById('helpBtnDashboard');
        const helpModalDashboard = document.getElementById('helpModalDashboard');
        const closeHelpModalDashboard = document.getElementById('closeHelpModalDashboard');
        if (helpBtnDashboard && helpModalDashboard && closeHelpModalDashboard) {
            helpBtnDashboard.addEventListener('click', () => helpModalDashboard.style.display = 'flex');
            closeHelpModalDashboard.addEventListener('click', () => helpModalDashboard.style.display = 'none');
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') helpModalDashboard.style.display = 'none';
            });
        }
    </script>
</body>
</html>