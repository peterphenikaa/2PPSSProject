@extends('layouts.layouts')

@section('products')
<div class="flex flex-col lg:flex-row gap-10">
    {{-- Ảnh sản phẩm --}}
    <div class="w-full lg:w-1/2">
        <img src="{{ asset('storage/' . $product->main_image) }}" class="w-full mb-4">
        <div class="grid grid-cols-4 gap-2">
            @foreach ($product->additional_images as $img)
                <img src="{{ asset('storage/' . $img) }}" class="w-full h-24 object-cover border">
            @endforeach
        </div>
    </div>

    {{-- Thông tin sản phẩm --}}
    <div class="w-full lg:w-1/2">
        <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>
        <p class="text-gray-500 mb-2">{{ $product->category }} | Mã: {{ $product->style_code }}</p>
        <p class="text-black text-xl font-semibold mb-4">{{ number_format($product->price, 2) }} đô la</p>

        <div class="mb-4">
            <p class="font-semibold">Kích thước có sẵn:</p>
            <div class="flex flex-wrap gap-2 mt-2">
                @foreach ($product->available_sizes as $size)
                    <span class="border px-3 py-1 rounded">{{ $size }}</span>
                @endforeach
            </div>
        </div>

        <div class="mb-4">
            <p class="font-semibold">Mô tả:</p>
            <p>{{ $product->description }}</p>
        </div>

        <p class="text-sm text-gray-500">Màu: {{ $product->colorway }}</p>
    </div>
</div>
@endsection