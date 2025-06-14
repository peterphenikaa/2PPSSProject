@extends('layouts.layouts')

@section('content')
<div class="bg-gray-50 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-2xl p-8 md:p-12">
        <div class="mb-6">
            <a href="{{ route('shop.blog.index') }}" class="text-indigo-600 hover:underline text-sm flex items-center gap-1">
                <span class="material-icons-round text-base">arrow_back</span> Quay lại Blog
            </a>
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 leading-tight">{{ $blog->title }}</h1>
        <div class="flex flex-wrap items-center text-gray-500 text-sm mb-8 gap-3">
            <span>
                Đăng ngày
                @if($blog->created_at)
                    {{ \Carbon\Carbon::parse($blog->created_at)->format('d/m/Y') }}
                @else
                    Không rõ
                @endif
            </span>
            <span class="mx-2">•</span>
            <span>Tác giả: <span class="font-semibold text-gray-700">Admin</span></span>
        </div>
        <div class="mb-8 rounded-xl overflow-hidden shadow-lg">
            @if($blog->image && file_exists(public_path('images/' . $blog->image)))
                <img src="{{ asset('images/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-full h-72 object-cover rounded-xl">
            @else
                <div class="w-full h-72 bg-gray-100 flex items-center justify-center rounded-xl">
                    <span class="material-icons-round text-gray-400 text-6xl">image_not_supported</span>
                </div>
            @endif
        </div>
        <article class="prose prose-lg max-w-none text-gray-800 leading-relaxed">
            {!! $blog->content !!}
        </article>
    </div>
</div>
@endsection

@section('meta_title', $blog->title)
@section('meta_description', Str::limit(strip_tags($blog->content), 150))
@section('meta_image', asset('storage/' . $blog->image)) 