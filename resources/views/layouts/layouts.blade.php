<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('meta_title', '2PSS Sneaker - Bùng nổ phong cách – Định hình cá tính')</title>
    <meta name="description" content="@yield('meta_description', 'Cửa hàng giày sneaker chính hãng, đa dạng thương hiệu, giá tốt, giao hàng toàn quốc.')">
    <meta property="og:title" content="@yield('meta_title', '2PSS Sneaker - Bùng nổ phong cách – Định hình cá tính')">
    <meta property="og:description" content="@yield('meta_description', 'Cửa hàng giày sneaker chính hãng, đa dạng thương hiệu, giá tốt, giao hàng toàn quốc.')">
    <meta property="og:image" content="@yield('meta_image', asset('images/anh_main.jpg'))">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    @vite('resources/css/app.css')
    @vite('resources/css/header.css')
    @vite('resources/css/footer.css')
    @vite('resources/js/app.js')
    @vite('resources/css/home.css')
</head>

<body>
    @include('layouts.header')
    <script>
        // Ẩn header khi lướt xuống, hiện lại khi lướt lên
        document.addEventListener('DOMContentLoaded', function() {
            let lastScroll = 0;
            const header = document.querySelector('header, .header, #header');
            if (!header) return;
            window.addEventListener('scroll', function() {
                const currentScroll = window.pageYOffset;
                if (currentScroll > lastScroll && currentScroll > 80) {
                    header.style.transform = 'translateY(-100%)';
                    header.style.transition = 'transform 0.3s';
                } else {
                    header.style.transform = 'translateY(0)';
                    header.style.transition = 'transform 0.3s';
                }
                lastScroll = currentScroll;
            });
        });
    </script>
    <main>
        @hasSection('content')
            @yield('content')
        @else
            <section class="main-banner">
                <img src="{{ asset('images/anh_main.jpg') }}" alt="Main Banner" class="w-full h-full object-cover"
                    loading="eager">
                <div class="banner-gradient"></div>
                <div class="banner-content">
                    <h1 class="banner-title">2PSS SNEAKERS</h1>
                    <p class="banner-desc">Bùng nổ phong cách – Định hình cá tính</p>
                    <a href="/products" class="banner-cta">Mua ngay</a>
                </div>
            </section>
            <section class="brands-section py-16 bg-gray-50">
                <div class="container mx-auto px-4">
                    <h3 class="text-center section-title">THƯƠNG HIỆU NỔI BẬT</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 md:gap-8">
                        <!-- Nike -->
                        <a href="{{ route('products.brand', 'nike') }}" class="brand-card flex flex-col items-center hover:text-blue-600">
                            <img src="{{ asset('images/nike.png') }}" alt="Nike" class="brand-img mb-4">
                            <span class="font-medium text-gray-700 hover:text-inherit">NIKE</span>
                        </a>
                        <!-- Adidas -->
                        <a href="{{ route('products.brand', 'adidas') }}" class="brand-card flex flex-col items-center hover:text-blue-600">
                            <img src="{{ asset('images/adidas.png') }}" alt="Adidas" class="brand-img mb-4">
                            <span class="font-medium text-gray-700 hover:text-inherit">ADIDAS</span>
                        </a>
                        <!-- Puma -->
                        <a href="{{ route('products.brand', 'puma') }}" class="brand-card flex flex-col items-center hover:text-blue-600">
                            <img src="{{ asset('images/PUMA.png') }}" alt="Puma" class="brand-img mb-4">
                            <span class="font-medium text-gray-700 hover:text-inherit">PUMA</span>
                        </a>
                        <!-- Vans -->
                        <a href="{{ route('products.brand', 'vans') }}" class="brand-card flex flex-col items-center hover:text-blue-600">
                            <img src="{{ asset('images/Vans.png') }}" alt="Vans" class="brand-img mb-4">
                            <span class="font-medium text-gray-700 hover:text-inherit">VANS</span>
                        </a>
                        <!-- New Balance -->
                        <a href="{{ route('products.brand', 'newbalance') }}" class="brand-card flex flex-col items-center hover:text-blue-600">
                            <img src="{{ asset('images/new balance.png') }}" alt="New Balance" class="brand-img mb-4">
                            <span class="font-medium text-gray-700 hover:text-inherit">NEW BALANCE</span>
                        </a>
                    </div>
                </div>
            </section>
            <section class="featured-blogs py-16 bg-white">
                <div class="container mx-auto px-4">
                    <h3 class="section-title text-center mb-8">BLOG NỔI BẬT</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @php
                            $featuredBlogs = 
                                \App\Models\Blog::where('status', 'published')
                                    ->orderByDesc('created_at')
                                    ->take(3)
                                    ->get();
                        @endphp
                        @foreach($featuredBlogs as $blog)
                        <a href="{{ route('shop.blog.show', $blog->slug) }}" class="rounded-xl shadow hover:shadow-lg transition bg-white border border-gray-100 hover:border-indigo-400 flex flex-col overflow-hidden">
                            <div class="w-full h-48 flex items-center justify-center overflow-hidden mb-3 bg-gray-50 rounded-t-lg">
                                @if($blog->image)
                                    <img src="{{ asset('images/'.$blog->image) }}" alt="{{ $blog->title }}" class="max-h-full max-w-full object-contain transition-transform duration-300 group-hover:scale-105 group-hover:shadow-md">
                                @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                        <span class="material-icons-round text-gray-400 text-5xl">image_not_supported</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4 flex-1 flex flex-col">
                                <h4 class="font-semibold text-gray-800 text-base md:text-lg line-clamp-2 mb-2">{{ $blog->title }}</h4>
                                <p class="text-gray-500 text-xs md:text-sm mb-1 line-clamp-3">{!! Str::limit(strip_tags($blog->content), 100) !!}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </section>
            <section class="featured-products py-16 bg-white">
                <div class="container mx-auto px-4">
                    <h3 class="section-title text-center mb-8">SẢN PHẨM MỚI</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @isset($newProducts)
                            @foreach ($newProducts as $product)
                                <div class="rounded-xl p-4 shadow hover:shadow-lg transition bg-white group border border-gray-100 hover:border-indigo-400">
                                    <a href="{{ route('products.show', $product->id) }}">
                                        <div class="w-full h-48 flex items-center justify-center overflow-hidden mb-3 bg-gray-50 rounded-lg">
                                            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}"
                                                class="max-h-full max-w-full object-contain transition-transform duration-300 group-hover:scale-105 group-hover:shadow-md">
                                        </div>
                                        <h4 class="mt-2 font-semibold text-gray-800 text-base md:text-lg line-clamp-1">{{ $product->name }}</h4>
                                        <p class="text-gray-500 text-xs md:text-sm mb-1">{{ number_format($product->price) }} đ</p>
                                    </a>
                                </div>
                            @endforeach
                        @endisset
                    </div>
                </div>
            </section>
        @endif
    </main>
    @include('layouts.footer')
</body>

</html>
