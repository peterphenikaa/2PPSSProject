@extends('layouts.layouts')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-pink-50 py-8 px-2">
    <div class="bg-white rounded-2xl shadow-xl p-8 max-w-lg w-full text-center">
        <h2 class="text-2xl font-bold mb-4 text-pink-600">Thanh toán qua Momo/VietQR</h2>
        <p class="mb-2 text-gray-700">Quét mã QR bên dưới bằng app Momo, ngân hàng hoặc ứng dụng hỗ trợ VietQR để thanh toán đơn hàng.</p>
        <div class="flex justify-center mb-4">
            <img src="{{ asset('images/momo-qr-demo.jpg') }}" alt="QR Momo" class="w-64 h-64 rounded-xl border shadow" />
        </div>
        <div class="mb-2 text-lg font-semibold">Số tiền: <span class="text-green-600">{{ number_format($order->total_price) }}₫</span></div>
        <div class="mb-2">Nội dung chuyển khoản:</div>
        <div class="mb-4 p-2 bg-gray-100 rounded font-mono text-base select-all">2PSS{{ $order->id }}</div>
        <div class="mb-4 text-sm text-gray-500">Vui lòng chuyển đúng số tiền và nội dung để được xác nhận đơn hàng nhanh nhất.</div>
        <a href="/" class="inline-block mt-4 px-6 py-2 bg-pink-600 text-white rounded-lg font-bold hover:bg-pink-700 transition">Về trang chủ</a>
    </div>
</div>
@endsection 