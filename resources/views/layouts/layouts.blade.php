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
        
    </main>
    @include('layouts.footer')
</body>

</html>
