@extends('layouts.layouts')

@section('content')
    <div class="bg-gray-50 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1
                    class="text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl flex items-center justify-center gap-3">
                    <span>Blog 2PSS Sneakers</span>
                </h1>
                <p class="mt-5 max-w-xl mx-auto text-xl text-gray-500">
                    Cập nhật tin tức, xu hướng và kiến thức về giày sneaker
                </p>
            </div>

            <!-- Search Section -->
            <div class="max-w-2xl mx-auto mb-12">
                <form action="{{ route('shop.blog.index') }}" method="GET" class="relative">
                    <div class="flex shadow-sm rounded-lg">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Tìm kiếm bài viết..."
                            class="flex-1 min-w-0 block w-full px-5 py-3 rounded-l-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-3 border border-transparent text-sm font-medium rounded-r-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Tìm kiếm
                        </button>
                    </div>
                    @if (request('search'))
                        <div class="mt-2 text-sm text-gray-600">
                            Kết quả tìm kiếm cho: <span class="font-semibold">"{{ request('search') }}"</span>
                            <a href="{{ route('shop.blog.index') }}" class="ml-2 text-indigo-600 hover:text-indigo-800">
                                <span class="material-icons-round align-middle text-base">close</span> Xóa bộ lọc
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Blog Posts Grid -->
            @if ($blogs->count() > 0)
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3" id="blog-list">
                    @foreach ($blogs as $blog)
                        <article
                            class="flex flex-col overflow-hidden rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 bg-white">
                            <!-- Featured Image -->
                            <div class="h-56 w-full overflow-hidden">
                                @if ($blog->image)
                                    <img src="{{ asset('images/' . $blog->image) }}" alt="{{ $blog->title }}"
                                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                        <span class="material-icons-round text-gray-400 text-5xl">image_not_supported</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="flex-1 p-6 flex flex-col">
                                <div class="flex-1">
                                    <h2 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">
                                        {{ $blog->title }}
                                    </h2>
                                    <p class="text-gray-600 mb-4 line-clamp-3">
                                        {!! Str::limit(strip_tags($blog->content), 150) !!}
                                    </p>
                                </div>
                                <div class="mt-auto pt-4 border-t border-gray-100">
                                    <a href="{{ route('shop.blog.show', $blog->slug) }}"
                                        class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center transition-colors">
                                        Đọc bài viết
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16" id="blog-list-empty">
                    <span class="material-icons-round text-gray-400 text-6xl mb-4">article</span>
                    <h3 class="text-lg font-medium text-gray-900">Không tìm thấy bài viết nào</h3>
                    <p class="mt-2 text-gray-500">
                        @if (request('search'))
                            Không có kết quả phù hợp với từ khóa "{{ request('search') }}"
                        @else
                            Hiện chưa có bài viết nào được đăng tải
                        @endif
                    </p>
                    @if (request('search'))
                        <div class="mt-4">
                            <a href="{{ route('shop.blog.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                Xem tất cả bài viết
                            </a>
                        </div>
                    @endif
                </div>
                @if(request('search') && $blogs->count() == 0)
                    <div class="text-gray-500 italic text-center">
                        Không tìm thấy bài viết phù hợp.
                    </div>
                @endif
            @endif

            <!-- Pagination -->
            @if ($blogs->hasPages())
                <div class="mt-12" id="blog-pagination">
                    {{ $blogs->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
@endpush

@section('meta_title', 'Blog - 2PSS Sneaker')
@section('meta_description', 'Tổng hợp các bài viết, tin tức, xu hướng sneaker mới nhất từ 2PSS Sneaker.')
@section('meta_image', asset('images/anh_main.jpg'))

