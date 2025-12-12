{{-- Example: Hiển thị ảnh từ MinIO --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $product->name }}</h1>

        {{-- Main Image --}}
        <div class="main-image">
            @if($product->image)
                {{-- Nếu lưu full URL trong DB --}}
                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full">

                {{-- Hoặc nếu lưu path, dùng Storage::url() --}}
                {{-- <img src="{{ Storage::disk('minio')->url($product->image) }}" alt="{{ $product->name }}"> --}}
            @else
                <img src="{{ asset('images/placeholder.jpg') }}" alt="No image">
            @endif
        </div>

        {{-- Additional Images --}}
        @if($product->additional_images && is_array($product->additional_images))
            <div class="grid grid-cols-4 gap-4 mt-4">
                @foreach($product->additional_images as $image)
                    <div class="aspect-square">
                        <img src="{{ $image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Form Upload với MinIO --}}
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label>Ảnh chính</label>
                <input type="file" name="main_image" accept="image/*">
                @error('main_image')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label>Ảnh phụ (nhiều ảnh)</label>
                <input type="file" name="additional_images[]" multiple accept="image/*">
                @error('additional_images.*')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                Cập nhật sản phẩm
            </button>
        </form>
    </div>
@endsection

{{--
NOTES:
1. Ảnh được lưu dạng URL đầy đủ trong DB: http://localhost:9000/laravel-images/products/image.jpg
2. Có thể truy cập trực tiếp qua URL này vì bucket được set public
3. Không cần asset() hay public_path() nữa
4. Dễ dàng migrate sang cloud storage khác (AWS S3, Google Cloud Storage) sau này
--}}