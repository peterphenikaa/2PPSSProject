@extends('layouts.layouts')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Giỏ hàng của bạn</h1>
    @if(count($cart) === 0)
        <p class="text-gray-500">Giỏ hàng của bạn đang trống.</p>
        <a href="/" class="text-blue-600 hover:underline">Tiếp tục mua sắm</a>
    @else
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 mb-6">
                    <thead>
                        <tr>
                            <th class="p-3 border-b">Ảnh</th>
                            <th class="p-3 border-b">Tên sản phẩm</th>
                            <th class="p-3 border-b">Size</th>
                            <th class="p-3 border-b">Giá</th>
                            <th class="p-3 border-b">Số lượng</th>
                            <th class="p-3 border-b">Thành tiền</th>
                            <th class="p-3 border-b">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($cart as $key => $item)
                            @php $total += $item['price'] * $item['quantity']; @endphp
                            <tr>
                                <td class="p-3 border-b">
                                    @if($item['image'])
                                        <img src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded">
                                    @else
                                        <span class="text-gray-400">Không có ảnh</span>
                                    @endif
                                </td>
                                <td class="p-3 border-b">{{ $item['name'] }}</td>
                                <td class="p-3 border-b">{{ $item['size'] }}</td>
                                <td class="p-3 border-b">{{ number_format($item['price']) }}₫</td>
                                <td class="p-3 border-b">
                                    <form action="{{ route('cart.update') }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="key" value="{{ $key }}">
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-16 border rounded p-1">
                                        <button type="submit" class="text-blue-600 hover:underline">Cập nhật</button>
                                    </form>
                                </td>
                                <td class="p-3 border-b">{{ number_format($item['price'] * $item['quantity']) }}₫</td>
                                <td class="p-3 border-b">
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="key" value="{{ $key }}">
                                        <button type="submit" class="text-red-600 hover:underline">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="flex justify-between items-center mb-6">
                <div class="text-lg font-semibold">Tổng cộng: <span class="text-green-600">{{ number_format($total) }}₫</span></div>
                <a href="{{ route('cart.checkout') }}" class="bg-black text-white px-6 py-2 rounded hover:bg-gray-800 transition">Mua hàng</a>
            </div>
        </form>
        <a href="/" class="text-blue-600 hover:underline">Tiếp tục mua sắm</a>
    @endif
</div>
@endsection 