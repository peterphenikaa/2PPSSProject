@extends('layouts.layouts')
@section('content')
<div class="container mx-auto px-4 py-10">
    <h2 class="text-2xl font-bold mb-6">Kết quả tìm kiếm cho: <span class="text-indigo-600">{{ $q }}</span></h2>
    <div class="mb-10">
        <h3 class="text-xl font-semibold mb-4">Sản phẩm</h3>
        @if($products->count())
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <a href="{{ route('products.show', $product->id) }}" class="block rounded-xl p-4 hover:shadow-lg transition">
                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-32 object-contain mb-2">
                        <div class="font-semibold">{{ $product->name }}</div>
                        <div class="text-gray-500 text-sm">{{ $product->brand }} - {{ $product->category }}</div>
                        <div class="text-indigo-600 font-bold mt-1">{{ number_format($product->price) }}₫</div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-gray-500 italic">Không tìm thấy sản phẩm phù hợp.</div>
        @endif
    </div>
    <div>
        <h3 class="text-xl font-semibold mb-4">Bài viết</h3>
        @if($blogs->count())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($blogs as $blog)
                    <a href="{{ route('shop.blog.show', $blog->slug) }}" class="block rounded-xl p-4 hover:shadow-lg transition">
                        @if($blog->image)
                            <img src="{{ asset('images/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-full h-32 object-cover mb-2">
                        @endif
                        <div class="font-semibold">{{ $blog->title }}</div>
                        <div class="text-gray-500 text-sm mb-1">{!! Str::limit(strip_tags($blog->content), 80) !!}</div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-gray-500 italic">Không tìm thấy bài viết phù hợp.</div>
        @endif
    </div>
</div>
@endsection
