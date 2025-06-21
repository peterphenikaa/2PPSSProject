<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</title>
    @vite(['resources/css/app.css', 'resources/css/createproduct.css', 'resources/css/dashboard.css'])
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
</head>
<body class="bg-gray-50" style="font-family: 'Rubik', sans-serif;">
    <x-sidebar />
    <div class="main-content">
        <header class="mb-6">
            <div class="flex items-center text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <span class="mx-2">/</span>
                <a href="{{ route('admin.order') }}" class="hover:text-indigo-600">Đơn hàng</a>
                <span class="mx-2">/</span>
                <span class="text-indigo-600">Chi tiết đơn hàng #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Chi tiết đơn hàng</h1>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.order') }}" class="btn-secondary">
                        <span class="material-icons-round">arrow_back</span>
                        Quay về danh sách
                    </a>
                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn-primary">
                        <span class="material-icons-round">edit</span>
                        Chỉnh sửa
                    </a>
                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn đơn hàng này? Hành động này không thể hoàn tác.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger-outline">
                            <span class="material-icons-round">delete</span>
                            Xóa
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                <div class="form-section">
                    <h2 class="section-title"><span class="section-icon material-icons-round">badge</span>Thông tin khách hàng</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="info-field">
                            <label>Tên khách hàng</label>
                            <p>{{ $order->user->name ?? $order->recipient_name }}</p>
                        </div>
                        <div class="info-field">
                            <label>Số điện thoại</label>
                            <p>{{ $order->recipient_phone }}</p>
                        </div>
                        <div class="info-field md:col-span-2">
                            <label>Địa chỉ giao hàng</label>
                            <p id="address-detail">{{ $order->address_detail }}, <span id="ward-name">{{ $order->ward }}</span>, <span id="district-name">{{ $order->district }}</span>, <span id="province-name">{{ $order->province }}</span></p>
                        </div>
                    </div>
                </div>
                
                <div class="form-section">
                    <h2 class="section-title"><span class="section-icon material-icons-round">inventory_2</span>Sản phẩm trong đơn</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="table-header">Sản phẩm</th>
                                    <th class="table-header">Size</th>
                                    <th class="table-header">Số lượng</th>
                                    <th class="table-header">Giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td class="table-cell font-medium">{{ $item->product->name ?? 'Sản phẩm không tồn tại' }}</td>
                                    <td class="table-cell">{{ $item->size }}</td>
                                    <td class="table-cell">{{ $item->quantity }}</td>
                                    <td class="table-cell">{{ number_format($item->price, 0, ',', '.') }}₫</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <div class="form-section">
                    <h2 class="section-title"><span class="section-icon material-icons-round">receipt_long</span>Chi tiết đơn hàng</h2>
                    <div class="space-y-4">
                        <div class="info-field">
                            <label>Mã đơn hàng</label>
                            <p class="font-mono">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="info-field">
                            <label>Ngày đặt</label>
                            <p>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : 'Chưa có' }}</p>
                        </div>
                        <div class="info-field">
                            <label>Tổng tiền</label>
                            <p class="text-xl font-bold text-indigo-600">{{ number_format($order->total_price, 0, ',', '.') }}₫</p>
                        </div>
                        <div class="info-field">
                            <label>Phương thức thanh toán</label>
                            <p class="px-3 py-1 bg-gray-100 rounded-full text-sm font-medium w-fit">{{ strtoupper($order->payment_method) }}</p>
                        </div>
                        <div class="info-field">
                            <label>Trạng thái hiện tại</label>
                            <p class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                @if($order->status=='Đã giao') bg-green-100 text-green-700
                                @elseif($order->status=='Đang giao hàng') bg-yellow-100 text-yellow-700
                                @elseif($order->status=='Đã thanh toán Momo') bg-blue-100 text-blue-700
                                @elseif($order->status=='Chờ thanh toán Momo') bg-purple-100 text-purple-700
                                @elseif($order->status=='Chờ hoàn hàng') bg-orange-100 text-orange-700
                                @elseif($order->status=='Đã hoàn hàng') bg-gray-200 text-gray-700
                                @elseif($order->status=='Đã hủy') bg-red-100 text-red-700
                                @else bg-red-100 text-red-700 @endif
                            ">{{ $order->status }}</p>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="section-title"><span class="section-icon material-icons-round">sync</span>Cập nhật trạng thái</h2>
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        <div class="space-y-3">
                            <select name="status" id="status" class="form-input">
                                <option value="Chờ xác nhận" @if($order->status=='Chờ xác nhận') selected @endif>Chờ xác nhận</option>
                                <option value="Chờ thanh toán Momo" @if($order->status=='Chờ thanh toán Momo') selected @endif>Chờ thanh toán Momo</option>
                                <option value="Đã thanh toán Momo" @if($order->status=='Đã thanh toán Momo') selected @endif>Đã thanh toán Momo</option>
                                <option value="Đang giao hàng" @if($order->status=='Đang giao hàng') selected @endif>Đang giao hàng</option>
                                <option value="Đã giao" @if($order->status=='Đã giao') selected @endif>Đã giao</option>
                                <option value="Chờ hoàn hàng" @if($order->status=='Chờ hoàn hàng') selected @endif>Chờ hoàn hàng</option>
                                <option value="Đã hoàn hàng" @if($order->status=='Đã hoàn hàng') selected @endif>Đã hoàn hàng</option>
                                <option value="Đã hủy" @if($order->status=='Đã hủy') selected @endif>Đã hủy</option>
                            </select>
                            <button type="submit" class="btn-primary w-full">
                                <span class="material-icons-round">save</span>
                                Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    window.addEventListener('DOMContentLoaded', async () => {
        function isNumber(val) { return !isNaN(val) && val !== '' && val !== null; }
        const province = document.getElementById('province-name');
        const district = document.getElementById('district-name');
        const ward = document.getElementById('ward-name');
        if (province && isNumber(province.textContent.trim())) {
            const res = await fetch('https://provinces.open-api.vn/api/p/' + province.textContent.trim());
            if (res.ok) { const data = await res.json(); province.textContent = data.name; }
        }
        if (district && isNumber(district.textContent.trim())) {
            const res = await fetch('https://provinces.open-api.vn/api/d/' + district.textContent.trim());
            if (res.ok) { const data = await res.json(); district.textContent = data.name; }
        }
        if (ward && isNumber(ward.textContent.trim())) {
            const res = await fetch('https://provinces.open-api.vn/api/w/' + ward.textContent.trim());
            if (res.ok) { const data = await res.json(); ward.textContent = data.name; }
        }
    });
    </script>
</body>
</html> 