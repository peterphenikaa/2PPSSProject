@extends('layouts.layouts')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Giỏ hàng của bạn</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if(empty($cart))
        <p class="text-gray-500">Giỏ hàng của bạn đang trống.</p>
        <a href="{{ url('/products/sneakers') }}" class="text-blue-600 hover:underline">Tiếp tục mua sắm</a>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 mb-6">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left">Sản phẩm</th>
                        <th class="p-3 text-center">Size</th>
                        <th class="p-3 text-center">Số lượng</th>
                        <th class="p-3 text-right">Giá</th>
                        <th class="p-3 text-right">Thành tiền</th>
                        <th class="p-3 text-center">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $details)
                        @php
                            $product = $products[$details['product_id']] ?? null;
                            if(!$product) continue; // Skip if product not found
                            $total += $details['price'] * $details['quantity'];
                        @endphp
                        <tr class="border-b">
                            <td class="p-4 flex items-center">
                                @if($product && $product->image)
                                    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $details['name'] }}" class="w-20 h-20 object-cover rounded mr-4">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 flex items-center justify-center rounded mr-4">
                                        <span class="text-gray-400 text-xs">No Image</span>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold">{{ $details['name'] }}</p>
                                    <p class="text-gray-500 text-sm">Thương hiệu: {{ $product->brand }}</p>
                                </div>
                            </td>
                            <td class="p-4 align-middle">
                                <form action="{{ route('cart.update') }}" method="POST" id="update-form-{{ $id }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <select name="size" class="form-select w-24 border rounded p-1.5 text-sm" onchange="document.getElementById('update-form-{{ $id }}').submit()">
                                        @if ($product && is_array($product->available_sizes))
                                            @foreach($product->available_sizes as $size)
                                                <option value="{{ $size }}" {{ $details['size'] == $size ? 'selected' : '' }}>
                                                    {{ $size }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="{{ $details['size'] }}" selected>{{ $details['size'] }}</option>
                                        @endif
                                    </select>
                                    {{-- The quantity input is part of the same form but in another table cell --}}
                            </td>
                            <td class="p-4 align-middle">
                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" class="w-16 border rounded p-1 text-center" onchange="document.getElementById('update-form-{{ $id }}').submit()">
                                </form>
                            </td>
                            <td class="p-4 align-middle text-right">{{ number_format($details['price']) }}₫</td>
                            <td class="p-4 align-middle text-right font-semibold">{{ number_format($details['price'] * $details['quantity']) }}₫</td>
                            <td class="p-4 align-middle text-center">
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex justify-between items-center mt-6">
            <a href="{{ url('/products/sneakers') }}" class="text-blue-600 hover:underline">&larr; Tiếp tục mua sắm</a>
            <div class="text-right">
                <p class="text-lg">Tổng cộng: <span class="font-bold text-xl text-green-600">{{ number_format($total) }}₫</span></p>
                <a href="{{ route('cart.checkout') }}" class="mt-2 inline-block bg-black text-white px-8 py-3 rounded hover:bg-gray-800 transition font-semibold">Tiến hành thanh toán</a>
            </div>
        </div>
    @endif
</div>
@endsection