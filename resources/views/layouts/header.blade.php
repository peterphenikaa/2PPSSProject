@push('styles')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
@endpush
<header class="header bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100"
    style="font-family: 'Rubik', Arial, Helvetica, sans-serif;">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="/" class="flex items-center">
                <img src="{{ asset('images/2PSS SNEAKERSS.png') }}" alt="2PSS SNEAKERS"
                    class="h-15 md:h-13 transition-all duration-300 hover:opacity-90">
            </a>

            <!-- Main Navigation - Desktop -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="/"
                    class="nav-link text-gray-900 font-semibold text-lg hover:text-red-600 transition-colors duration-200">TRANG
                    CHỦ</a>

                <!-- Products Dropdown with Categories -->
                <div class="relative group">
                    <button
                        class="nav-link text-gray-900 font-semibold text-lg flex items-center hover:text-red-600 transition-colors duration-200">
                        SẢN PHẨM
                        <svg class="w-4 h-4 ml-1.5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div
                        class="dropdown-menu absolute left-0 mt-2 w-96 bg-white rounded-md shadow-lg z-50 border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-1 group-hover:translate-y-0">
                        <div class="grid grid-cols-2 gap-4 p-4">
                            <!-- Category Column -->
                            <div>
                                <h3 class="font-bold text-gray-900 mb-2 pb-1 border-b">DANH MỤC</h3>
                                <a href="{{ route('products.filter', 'men') }}"
                                    class="block px-3 py-2 text-gray-800 hover:bg-gray-50 hover:text-red-600 font-medium">Giày
                                    nam</a>
                                <a href="{{ route('products.filter', 'women') }}"
                                    class="block px-3 py-2 text-gray-800 hover:bg-gray-50 hover:text-red-600 font-medium">Giày
                                    nữ</a>
                                <a href="{{ route('products.filter', 'sports') }}"
                                    class="block px-3 py-2 text-gray-800 hover:bg-gray-50 hover:text-red-600 font-medium">Giày
                                    thể thao</a>
                                <a href="{{ route('products.filter', 'sneakers') }}"
                                    class="block px-3 py-2 text-gray-800 hover:bg-gray-50 hover:text-red-600 font-medium">Sneaker</a>
                                <a href="{{ route('products.filter', 'new-arrivals') }}"
                                    class="block px-3 py-2 hover:bg-gray-50 hover:text-red-600 font-medium text-red-500">Hàng mới về</a>
                                <a href="{{ route('products.filter', 'best-sellers') }}"
                                    class="block px-3 py-2 text-gray-800 hover:bg-gray-50 hover:text-red-600 font-medium">Bán chạy</a>
                            </div>


                            <!-- Brands Column -->
                            <div>
                                <h3 class="font-bold text-gray-900 mb-2 pb-1 border-b">THƯƠNG HIỆU</h3>
                                <div class="grid grid-cols-2 gap-2">
                                    <a href="{{ route('products.brand', 'nike') }}"
                                        class="px-3 py-2 hover:bg-gray-50 rounded text-gray-800 hover:text-red-600">Nike</a>
                                    <a href="{{ route('products.brand', 'adidas') }}"
                                        class="px-3 py-2 hover:bg-gray-50 rounded text-gray-800 hover:text-red-600">Adidas</a>
                                    <a href="{{ route('products.brand', 'jordan') }}"
                                        class="px-3 py-2 hover:bg-gray-50 rounded text-gray-800 hover:text-red-600">Jordan</a>
                                    <a href="{{ route('products.brand', 'puma') }}"
                                        class="px-3 py-2 hover:bg-gray-50 rounded text-gray-800 hover:text-red-600">Puma</a>
                                    <a href="{{ route('products.brand', 'converse') }}"
                                        class="px-3 py-2 hover:bg-gray-50 rounded text-gray-800 hover:text-red-600">Converse</a>
                                    <a href="{{ route('products.brand', 'vans') }}"
                                        class="px-3 py-2 hover:bg-gray-50 rounded text-gray-800 hover:text-red-600">Vans</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Blog Link -->
                <a href="{{ route('shop.blog.index') }}"
                    class="nav-link text-gray-900 font-semibold text-lg hover:text-red-600 transition-colors duration-200">BLOG</a>

                <!-- Contact Link -->
                <a href="/contact"
                    class="nav-link text-gray-900 font-semibold text-lg hover:text-red-600 transition-colors duration-200">LIÊN
                    HỆ</a>
            </nav>

            <!-- Right Icons -->
            <div class="flex items-center space-x-5 md:space-x-6">
                <!-- Search Icon with Dropdown -->
                <div class="relative group">
                    <button
                        class="p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200 focus:outline-none">
                        <img src="{{ asset('images/icon_search.png') }}" alt="Search" class="h-5 w-5 md:h-6 md:w-6">
                    </button>
                    <div
                        class="absolute right-0 top-full mt-2 w-64 bg-white rounded-md shadow-lg z-50 border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-1 group-hover:translate-y-0">
                        <form action="/search" method="GET" class="p-3">
                            <div class="relative">
                                <input type="text" name="q" placeholder="Tìm giày, thương hiệu..."
                                    class="w-full border border-gray-300 rounded-full py-2 px-4 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                                <button type="submit" class="absolute right-3 top-2.5">
                                    <img src="{{ asset('images/icon_search.png') }}" alt="Search" class="h-4 w-4">
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Cart -->
                <a href="/cart" class="p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200 relative">
                    <img src="{{ asset('images/icon_cart.png') }}" alt="Giỏ hàng" class="h-5 w-5 md:h-6 md:w-6">

                </a>

                <!-- Account -->
                <div class="relative group hidden md:block">
                    <button
                        class="p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200 focus:outline-none">
                        <img src="{{ asset('images/person.png') }}" alt="Tài khoản" class="h-5 w-5 md:h-6 md:w-6">
                    </button>

                    <div
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-1 group-hover:translate-y-0">
                        @auth
                            <div class="p-4 border-b">
                                <p class="text-sm text-gray-700">Xin chào,</p>
                                <p class="font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                            </div>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Đăng xuất
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Đăng nhập
                            </a>
                            <a href="{{ route('register') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Đăng ký
                            </a>
                        @endauth
                    </div>
                </div>


                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button"
                    class="md:hidden p-1.5 rounded-md hover:bg-gray-100 transition-colors duration-200">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden bg-white border-t border-gray-100 py-3 hidden">
        <div class="container mx-auto px-4 space-y-3">
            <a href="/"
                class="block py-2 text-gray-900 font-semibold text-lg hover:text-red-600 transition-colors duration-200">TRANG
                CHỦ</a>

            <!-- Mobile Products Submenu -->
            <div class="relative">
                <button id="mobile-products-button"
                    class="w-full flex justify-between items-center py-2 text-gray-900 font-semibold text-lg hover:text-red-600 transition-colors duration-200">
                    <span>SẢN PHẨM</span>
                    <svg class="w-4 h-4 transform transition-transform duration-200" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                        </path>
                    </svg>
                </button>
                <div id="mobile-products-menu" class="hidden pl-4 mt-1 space-y-2">
                    <a href="/products/men" class="block py-1.5 text-gray-700 hover:text-red-600">Giày Nam</a>
                    <a href="/products/women" class="block py-1.5 text-gray-700 hover:text-red-600">Giày Nữ</a>
                    <a href="/products/sports" class="block py-1.5 text-gray-700 hover:text-red-600">Giày Thể Thao</a>
                    <a href="/products/sneakers" class="block py-1.5 text-gray-700 hover:text-red-600">Sneakers</a>
                    <a href="/new-arrivals" class="block py-1.5  hover:text-red-600 text-red-500">Hàng
                        Mới Về</a>
                    <a href="/best-sellers" class="block py-1.5 text-gray-700 hover:text-red-600">Bán Chạy</a>
                    <div class="border-t border-gray-200 mt-2 pt-2">
                        <h4 class="font-medium text-gray-900 mb-1">Thương hiệu</h4>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('products.brand', 'nike') }}" class="text-sm text-gray-700 hover:text-red-600">Nike</a>
                            <a href="{{ route('products.brand', 'adidas') }}" class="text-sm text-gray-700 hover:text-red-600">Adidas</a>
                            <a href="{{ route('products.brand', 'newbalance') }}" class="text-sm text-gray-700 hover:text-red-600">New
                                balance</a>
                            <a href="{{ route('products.brand', 'puma') }}" class="text-sm text-gray-700 hover:text-red-600">Puma</a>
                            <a href="{{ route('products.brand', 'converse') }}" class="text-sm text-gray-700 hover:text-red-600">Converse</a>
                            <a href="{{ route('products.brand', 'vans') }}" class="text-sm text-gray-700 hover:text-red-600">Vans</a>
                        </div>
                    </div>
                </div>
            </div>

            <a href="/blog"
                class="block py-2 text-gray-900 font-semibold text-lg hover:text-red-600 transition-colors duration-200">BLOG</a>
            <a href="/contact"
                class="block py-2 text-gray-900 font-semibold text-lg hover:text-red-600 transition-colors duration-200">LIÊN
                HỆ</a>

            <!-- Mobile Account Links -->
            <div class="pt-2 border-t border-gray-200 mt-2">
                <a href="{{ route('login') }}"
                    class="block py-2 text-gray-900 font-semibold text-lg hover:text-red-600 transition-colors duration-200">TÀI
                    KHOẢN</a>
                <a href="/cart"
                    class="block py-2 text-gray-900 font-semibold text-lg hover:text-red-600 transition-colors duration-200">GIỎ
                    HÀNG </a>
            </div>

            <!-- Mobile Search -->
            <form action="/search" method="GET" class="mt-3">
                <div class="relative">
                    <input type="text" name="q" placeholder="Tìm kiếm sản phẩm..."
                        class="w-full border border-gray-300 rounded-full py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <button type="submit" class="absolute left-3 top-2.5">
                        <img src="{{ asset('images/icon_search.png') }}" alt="Search" class="h-4 w-4">
                    </button>
                </div>
            </form>
        </div>
    </div>

    <link rel="canonical" href="{{ url()->current() }}" />
</header>