<a href="/products/new-arrivals" class="inline-block px-8 py-3 bg-gradient-to-r from-pink-500 to-purple-500 text-white font-bold rounded-full shadow-lg hover:scale-105 transition">Mua ngay</a>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
@foreach ($featuredBlogs as $blog)
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        @if ($blog->image)
            <img src="{{ asset('images/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-full h-40 object-cover rounded-t-xl">
        @else
            <div class="w-full h-40 bg-gray-100 flex items-center justify-center rounded-t-xl">
                <span class="material-icons-round text-gray-400 text-5xl">image_not_supported</span>
            </div>
        @endif
        <div class="p-4">
            <h3 class="font-bold text-lg mb-2">{{ $blog->title }}</h3>
            <p class="text-gray-600 text-sm mb-2">{!! Str::limit(strip_tags($blog->content), 80) !!}</p>
            <a href="{{ route('shop.blog.show', $blog->slug) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Đọc bài viết</a>
        </div>
    </div>
@endforeach
</div> 