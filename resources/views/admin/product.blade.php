<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard - 2PSS Sneakers</title>
    @vite(['resources/css/app.css', 'resources/css/dashboard.css', 'resources/css/product.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
</head>

<body>
    <x-sidebar />
    <!-- Main Content -->
    <div class="main-content ml-64 p-6">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <!-- Page title and breadcrumb -->
                <div>
                    <div class="flex items-center text-sm text-gray-500 mb-1">
                        <a href="/admin/dashboard" class="hover:text-indigo-600">Dashboard</a>
                        <span class="mx-2">/</span>
                        <span class="text-indigo-600">Sản phẩm</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-2">
                        <span class="material-icons-round text-indigo-600">category</span>
                        Quản lý sản phẩm
                    </h1>
                    <p class="text-gray-600 mt-1 text-sm md:text-base">Xem và quản lý tất cả sản phẩm của cửa hàng</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative hidden md:block">
                        <input type="text" placeholder="Tìm kiếm sản phẩm..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 w-64">
                        <span class="material-icons-round absolute left-3 top-2.5 text-gray-400">search</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button
                            class="relative p-2 rounded-full hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors">
                            <span class="material-icons-round">notifications</span>
                            <span
                                class="absolute top-0 right-0 h-2.5 w-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>
                        <button
                            class="p-2 rounded-full hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors">
                            <span class="material-icons-round">help_outline</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200 mt-4">
            <div class="px-6 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Danh sách sản phẩm</h2>
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <a href="{{ route('admin.product.create') }}">
                        <span class="material-icons-round mr-2 align-middle" style="font-size: 22px;">add</span>
                        <span class="align-middle">Tạo</span>
                    </a>
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="order-table">
                    <thead>
                        <tr>
                            <th class="w-20">ID</th>
                            <th>Tên SP</th>
                            <th>Giá</th>
                            <th class="w-40">Size</th>
                            <th class="w-32">Giới tính</th>
                            <th class="w-40">Thương hiệu</th>
                            <th class="w-40">Loại</th>
                            <th class="w-40">Màu sắc</th>
                            <th class="w-28">Còn hàng</th>
                            <th class="w-20">Cập nhật</th>
                            <th class="w-20">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="font-medium text-gray-900">
                                    #{{ str_pad($product['id'], 5, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $product['name'] }}</td>
                                <td class="font-medium">₫{{ number_format($product['price'], 0, ',', '.') }}</td>
                                <td>
                                    @if (is_array($product['sizes']))
                                        {{ implode(', ', $product['sizes']) }}
                                    @else
                                        Không rõ
                                    @endif
                                </td>
                                <td>{{ ucfirst($product['gender']) }}</td>
                                <td>{{ $product['brand'] }}</td>
                                <td>{{ $product['category'] }}</td>
                                <td>{{ $product['colorway'] }}</td>
                                <td>{{ $product['stock'] }}</td>
                                <td class="text-center">
                                    <button class="text-indigo-600 hover:text-indigo-800 transition-colors">
                                        <span class="material-icons-round">edit</span>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button class="text-red-600 hover:text-red-800 transition-colors">
                                        <span class="material-icons-round">delete</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="px-4 py-6 text-center text-gray-500">
                                    Không có sản phẩm nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>