<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trang chính</title>
    @vite('resources/css/app.css')
    @vite('resources/css/header.css')
    @vite('resources/css/footer.css')
    @vite('resources/js/app.js')
    @vite('resources/css/home.css')
    <!-- Google Fonts: Rubik -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        html,
        body {
            font-family: 'Rubik', sans-serif !important;
        }
    </style>
</head>

<body>
    @include('layouts.header')
    <main>
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
                    <div class="brand-card flex flex-col items-center hover:text-blue-600">
                        <img src="{{ asset('images/nike.png') }}" alt="Nike" class="brand-img mb-4">
                        <span class="font-medium text-gray-700 hover:text-inherit">NIKE</span>
                    </div>
                    <!-- Adidas -->
                    <div class="brand-card flex flex-col items-center hover:text-blue-600">
                        <img src="{{ asset('images/adidas.png') }}" alt="Adidas" class="brand-img mb-4">
                        <span class="font-medium text-gray-700 hover:text-inherit">ADIDAS</span>
                    </div>
                    <!-- Puma -->
                    <div class="brand-card flex flex-col items-center hover:text-blue-600">
                        <img src="{{ asset('images/PUMA.png') }}" alt="Puma" class="brand-img mb-4">
                        <span class="font-medium text-gray-700 hover:text-inherit">PUMA</span>
                    </div>
                    <!-- Vans -->
                    <div class="brand-card flex flex-col items-center hover:text-blue-600">
                        <img src="{{ asset('images/Vans.png') }}" alt="Vans" class="brand-img mb-4">
                        <span class="font-medium text-gray-700 hover:text-inherit">VANS</span>
                    </div>
                    <!-- New Balance -->
                    <div class="brand-card flex flex-col items-center hover:text-blue-600">
                        <img src="{{ asset('images/new balance.png') }}" alt="New Balance" class="brand-img mb-4">
                        <span class="font-medium text-gray-700 hover:text-inherit">NEW BALANCE</span>
                    </div>
                </div>
            </div>
        </section>
        <section class="featured-products py-16 bg-white">
            <div class="container mx-auto px-4">
                <h3 class="section-title text-center mb-8">SẢN PHẨM MỚI</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($newProducts as $product)
                        <div class="border rounded p-4 shadow hover:shadow-md transition">
                            <a href="{{ route('products.show', $product->id) }}">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-48 object-cover rounded">
                                <h4 class="mt-2 font-semibold text-gray-800">{{ $product->name }}</h4>
                                <p class="text-gray-500 text-sm">{{ number_format($product->price) }} đ</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

    </main>

    @include('layouts.footer')
</body>

</html>
