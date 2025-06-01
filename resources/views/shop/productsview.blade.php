@extends('layouts.layouts')


@section('products')
<div class="bg-white py-12 px-10">
  <div class="flex w-full gap-8 items-start">
    {{-- SIDEBAR --}}
    <form method="GET" action="{{ route('products.index') }}" class="w-[220px] flex-shrink-0 text-sm space-y-6" x-data>
        {{-- Tên sản phẩm --}}
        <div x-data="{ open: true }" class="border-b pb-2">
            <button type="button" @click="open = !open" class="flex justify-between w-full font-semibold">
                Tên sản phẩm
                <span x-show="!open">+</span><span x-show="open">−</span>
            </button>
            <div x-show="open" class="mt-2 space-y-1">
                @foreach($productNames as $name)

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="name[]" value="{{ $name }}" {{ collect(request('name'))->contains($name) ? 'checked' : '' }}>
                    {{ $name }}
                </label>
                @endforeach
            </div>
        </div>

        {{-- Giới tính --}}
        <div x-data="{ open: true }" class="border-b pb-2">
            <button type="button" @click="open = !open" class="flex justify-between w-full font-semibold">
                Giới tính
                <span x-show="!open">+</span><span x-show="open">−</span>
            </button>
            <div x-show="open" class="mt-2 space-y-1">
                @foreach($genders as $gender)
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="gender[]" value="{{ $gender }}" {{ collect(request('gender'))->contains($gender) ? 'checked' : '' }}>
                    {{ $gender }}
                </label>
                @endforeach
            </div>
        </div>

        {{-- Size --}}
        <div x-data="{ open: true }" class="border-b pb-2">
            <button type="button" @click="open = !open" class="flex justify-between w-full font-semibold">
                Size
                <span x-show="!open">+</span><span x-show="open">−</span>
            </button>
            <div x-show="open" class="mt-2 space-y-1">
                @foreach($sizes as $size)
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="size[]" value="{{ $size }}" {{ collect(request('size'))->contains($size) ? 'checked' : '' }}>
                    {{ $size }}
                </label>
                @endforeach
            </div>
        </div>

        {{-- Colorway --}}
        <div x-data="{ open: true }" class="border-b pb-2">
            <button type="button" @click="open = !open" class="flex justify-between w-full font-semibold">
                Colorway
                <span x-show="!open">+</span><span x-show="open">−</span>
            </button>
            <div x-show="open" class="mt-2 space-y-1">
                @foreach($colorways as $color)
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="colorway[]" value="{{ $color }}" {{ collect(request('colorway'))->contains($color) ? 'checked' : '' }}>
                    {{ $color }}
                </label>
                @endforeach
            </div>
        </div>

        {{-- Giá tối đa --}}
        <div>
            <label class="font-bold block mb-1">Giá tối đa (VNĐ)</label>
            <input type="range" name="price" min="50000" max="5000000" step="50000" value="{{ request('price', 5000000) }}"
                   oninput="this.nextElementSibling.innerText = parseInt(this.value).toLocaleString() + ' ₫'"
                   class="w-full">
            <span class="text-sm text-gray-700">
                {{ number_format(request('price', 5000000), 0, ',', '.') }} ₫
            </span>
        </div>

        <button type="submit" class="w-full bg-black text-white py-2 rounded hover:bg-gray-800 transition">
            Tìm sản phẩm
        </button>
    </form>

    {{-- PRODUCT LIST --}}
    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-10 pr-2">
        @forelse ($products as $product)
        <a href="{{ route('products.show', $product->slug) }}" class="group block overflow-hidden">
            <div class="w-full aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden">
                <img src="{{ asset($product->main_image) }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 ease-in-out">
            </div>
            <div class="mt-4">
                <h3 class="text-base font-semibold text-black group-hover:underline">{{ $product->name }}</h3>
                <p class="text-sm text-gray-500">{{ $product->category }} - {{ $product->gender }}</p>
                <p class="mt-1 text-lg font-bold text-black">{{ number_format($product->price, 0, ',', '.') }} ₫</p>
            </div>
        </a>
        @empty
        <p class="col-span-full">Không tìm thấy sản phẩm nào.</p>
        @endforelse
    </div>
  </div>
</div>
@endsection