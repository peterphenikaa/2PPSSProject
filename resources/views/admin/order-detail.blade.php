@extends('layouts.layouts')
@section('title', 'Chi tiết đơn hàng')
@section('content')
<div class="flex justify-center items-center min-h-[70vh] bg-gray-50 py-8">
    <div class="w-full max-w-3xl bg-white rounded-2xl shadow-xl border border-gray-200 p-8 relative">
        <a href="{{ route('admin.order') }}" class="absolute -top-5 left-4 flex items-center gap-1 text-indigo-600 hover:text-indigo-800 font-semibold text-sm bg-white px-3 py-1 rounded-full shadow border border-indigo-100 transition z-10">
            <span class="material-icons-round text-base">arrow_back</span> Quay về
        </a>
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
            <div class="flex items-center gap-3">
                <span class="material-icons-round text-indigo-600 text-3xl">receipt_long</span>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Chi tiết đơn hàng <span class="text-indigo-600">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></h2>
            </div>
            <div class="text-right">
                <div class="text-gray-500 text-sm">Ngày đặt: <span class="font-semibold text-gray-700">{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : 'Chưa có' }}</span></div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
            <div>
                <div class="mb-3 flex items-center gap-2">
                    <span class="material-icons-round text-gray-400">person</span>
                    <span class="font-semibold">Khách hàng:</span> <span>{{ $order->user->name ?? $order->recipient_name }}</span>
                </div>
                <div class="mb-3 flex items-center gap-2">
                    <span class="material-icons-round text-gray-400">call</span>
                    <span class="font-semibold">Số điện thoại:</span> <span>{{ $order->recipient_phone }}</span>
                </div>
                <div class="mb-3 flex items-start gap-2">
                    <span class="material-icons-round text-gray-400 mt-0.5">location_on</span>
                    <span class="font-semibold">Địa chỉ:</span>
                    <span id="address-detail">{{ $order->address_detail }}, <span id="ward-name">{{ $order->ward }}</span>, <span id="district-name">{{ $order->district }}</span>, <span id="province-name">{{ $order->province }}</span></span>
                </div>
                <div class="mb-3 flex items-center gap-2">
                    <span class="material-icons-round text-gray-400">credit_card</span>
                    <span class="font-semibold">Thanh toán:</span> <span class="uppercase">{{ $order->payment_method }}</span>
                </div>
            </div>
            <div>
                <div class="mb-3 flex items-center gap-2">
                    <span class="material-icons-round text-gray-400">attach_money</span>
                    <span class="font-semibold">Tổng tiền:</span>
                    <span class="text-xl font-bold text-indigo-700">₫{{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="mb-3 flex items-center gap-2">
                    <span class="material-icons-round text-gray-400">flag</span>
                    <span class="font-semibold">Trạng thái:</span>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                        @if($order->status=='Đã giao') bg-green-100 text-green-700
                        @elseif($order->status=='Đang giao hàng') bg-yellow-100 text-yellow-700
                        @elseif($order->status=='Đã thanh toán Momo') bg-blue-100 text-blue-700
                        @elseif($order->status=='Chờ thanh toán Momo') bg-purple-100 text-purple-700
                        @elseif($order->status=='Chờ hoàn hàng') bg-orange-100 text-orange-700
                        @elseif($order->status=='Đã hoàn hàng') bg-gray-200 text-gray-700
                        @elseif($order->status=='Đã hủy') bg-red-100 text-red-700
                        @else bg-red-100 text-red-700 @endif
                    ">{{ $order->status }}</span>
                </div>
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex items-center gap-2 mt-2">
                    @csrf
                    <label for="status" class="font-semibold">Cập nhật trạng thái:</label>
                    <select name="status" id="status" class="border rounded px-2 py-1 focus:ring-2 focus:ring-indigo-200">
                        <option value="Chờ xác nhận" @if($order->status=='Chờ xác nhận') selected @endif>Chờ xác nhận</option>
                        <option value="Chờ thanh toán Momo" @if($order->status=='Chờ thanh toán Momo') selected @endif>Chờ thanh toán Momo</option>
                        <option value="Đã thanh toán Momo" @if($order->status=='Đã thanh toán Momo') selected @endif>Đã thanh toán Momo</option>
                        <option value="Đang giao hàng" @if($order->status=='Đang giao hàng') selected @endif>Đang giao hàng</option>
                        <option value="Đã giao" @if($order->status=='Đã giao') selected @endif>Đã giao</option>
                        <option value="Chờ hoàn hàng" @if($order->status=='Chờ hoàn hàng') selected @endif>Chờ hoàn hàng</option>
                        <option value="Đã hoàn hàng" @if($order->status=='Đã hoàn hàng') selected @endif>Đã hoàn hàng</option>
                        <option value="Đã hủy" @if($order->status=='Đã hủy') selected @endif>Đã hủy</option>
                    </select>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-1.5 rounded-lg font-semibold shadow hover:bg-indigo-700 transition">Lưu</button>
                </form>
            </div>
        </div>
        <div class="mb-2">
            <h3 class="font-semibold text-lg mb-2 flex items-center gap-2"><span class="material-icons-round text-gray-400">inventory_2</span> Sản phẩm</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border rounded-lg">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="py-2 px-4 text-left">Tên sản phẩm</th>
                            <th class="py-2 px-4 text-left">Size</th>
                            <th class="py-2 px-4 text-left">Số lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $item->product->name ?? 'Không rõ' }}</td>
                            <td class="py-2 px-4">{{ $item->size }}</td>
                            <td class="py-2 px-4">{{ $item->quantity }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
// Đổi code sang tên tỉnh/thành, quận/huyện, phường/xã nếu là số
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
@endsection 