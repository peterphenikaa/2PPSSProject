<header class="header bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="/" class="flex items-center">
                <img src="{{ asset('images/logo2pp.png') }}" alt="2PSS SNEAKERS" class="h-15 md:h-13 transition-all duration-300 hover:opacity-90">
            </a>

            <!-- Main Navigation - Desktop -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="/" class="nav-link text-gray-900 font-semibold text-lg hover:text-red-600 transition-colors duration-200">TRANG CHỦ</a>
                
                <!-- Products Dropdown -->
                <div class="relative group">
                    <button class="nav-link text-gray-900 font-semibold text-lg flex items-center hover:text-red-600 transition-colors duration-200">
                        SẢN PHẨM
                        <svg class="w-4 h-4 ml-1.5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="dropdown-menu absolute left-0 mt-2 w-96 bg-white rounded-md shadow-lg z-50 border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-1 group-hover:translate-y-0">
                        <div class="grid grid-cols-2 gap-4 p-4">
                            <!-- By Category -->
                            <div>
                                <h3 class="font-bold text-gray-900 mb-2 pb-1 border-b">DANH MỤC</h3>
                                <a href="/products/men" class="block px-3 py-2 text-gray-800 hover:bg-gray-50 hover:text-red-600 font-medium">GIÀY NAM</a>
                                <a href="/products/women" class="block px-3 py-2 text-gray-800 hover:bg-gray-50 hover:text-red-600 font-medium">GIÀY NỮ</a>
                                <a href="/products/sports" class="block px-3 py-2 text-gray-800 hover:bg-gray-50 hover:text-red-600 font-medium">GIÀY THỂ THAO</a>
                                <a href="/products/sneakers" class="block px-3 py-2 text-gray-800 hover:bg-gray-50 hover:text-red-600 font-medium">SNEAKERS</a>
                                <a href="/new-arrivals" class="block px-3 py-2 text-gray-800 hover:bg-gray-50 hover:text-red-600 font-medium">HÀNG MỚI VỀ</a>
                            </div>
                            
                            <!-- By Brand -->
                            <div>
                                <h3 class="font-bold text-gray-900 mb-2 pb-1 border-b">THƯƠNG HIỆU</h3>
                                <div class="grid grid-cols-2 gap-2">
                                    <a href="/brands/nike" class="flex items-center px-3 py-2 hover:bg-gray-50 rounded">
                                        <img src="{{ asset('assets/brands/nike.png') }}" class="h-6 mr-2" alt="Nike">
                                        <span class="text-gray-800 hover:text-red-600">Nike</span>
                                    </a>
                                    <a href="/brands/adidas" class="flex items-center px-3 py-2 hover:bg-gray-50 rounded">
                                        <img src="{{ asset('assets/brands/adidas.png') }}" class="h-6 mr-2" alt="Adidas">
                                        <span class="text-gray-800 hover:text-red-600">Adidas</span>
                                    </a>
                                    <a href="/brands/jordan" class="flex items-center px-3 py-2 hover:bg-gray-50 rounded">
                                        <img src="{{ asset('assets/brands/jordan.png') }}" class="h-6 mr-2" alt="Jordan">
                                        <span class="text-gray-800 hover:text-red-600">Jordan</span>
                                    </a>
                                    <a href="/brands/puma" class="flex items-center px-3 py-2 hover:bg-gray-50 rounded">
                                        <img src="{{ asset('assets/brands/puma.png') }}" class="h-6 mr-2" alt="Puma">
                                        <span class="text-gray-800 hover:text-red-600">Puma</span>
                                    </a>
                                    <a href="/brands/converse" class="flex items-center px-3 py-2 hover:bg-gray-50 rounded">
                                        <img src="{{ asset('assets/brands/converse.png') }}" class="h-6 mr-2" alt="Converse">
                                        <span class="text-gray-800 hover:text-red-600">Converse</span>
                                    </a>
                                    <a href="/brands/vans" class="flex items-center px-3 py-2 hover:bg-gray-50 rounded">
                                        <img src="{{ asset('assets/brands/vans.png') }}" class="h-6 mr-2" alt="Vans">
                                        <span class="text-gray-800 hover:text-red-600">Vans</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <a href="/sale" class="nav-link text-gray-900 font-semibold text-lg hover:text-red-600 transition-colors duration-200">KHUYẾN MÃI</a>
                <a href="/new-arrivals" class="nav-link text-gray-900 font-semibold text-lg hover:text-red-600 transition-colors duration-200">HÀNG MỚI</a>
            </nav>
            
            <!-- Right Icons -->
            <div class="flex items-center space-x-5 md:space-x-6">
                <!-- Search Form -->
                <form action="/search" method="GET" class="hidden md:flex items-center bg-gray-50 rounded-full px-4 py-2">
                    <input type="text" name="q" placeholder="Tìm giày, thương hiệu..." class="bg-transparent border-none focus:ring-0 text-sm w-40 lg:w-64">
                    <button type="submit" class="flex items-center justify-center ml-2">
                        <!-- Magnifying glass SVG icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" fill="none"/>
                            <line x1="16.5" y1="16.5" x2="21" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </form>
                
                <!-- Wishlist -->
                <a href="/wishlist" class="p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 md:h-8 md:w-8 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12.1 8.64l-.1.1-.11-.11C10.14 6.6 7.1 7.24 5.5 9.28c-1.6 2.04-.44 5.12 2.54 7.05l3.96 3.17c.3.24.74.24 1.04 0l3.96-3.17c2.98-1.93 4.14-5.01 2.54-7.05-1.6-2.04-4.64-2.68-6.49-.64z"/>
                    </svg>
                    <span class="wishlist-badge absolute -top-1.5 -right-1.5 bg-red-600 text-white rounded-full h-5 w-5 flex items-center justify-center text-xs font-bold">3</span>
                </a>
                
                <!-- Cart -->
                <a href="/cart" class="p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200 relative">
                    <img src="{{ asset('assets/icons/icon_cart.png') }}" alt="Giỏ hàng" class="h-5 w-5 md:h-6 md:w-6">
                    <span class="cart-badge absolute -top-1.5 -right-1.5 bg-red-600 text-white rounded-full h-5 w-5 flex items-center justify-center text-xs font-bold">5</span>
                </a>
                
                <!-- Account -->
                <a href="/account" class="p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200 hidden md:block">
                    <img src="{{ asset('images/user.png') }}" alt="Tài khoản" class="h-5 w-5 md:h-6 md:w-6">
                </a>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="md:hidden p-1.5 rounded-md hover:bg-gray-100 transition-colors duration-200">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden bg-white border-t border-gray-100 py-3 hidden">
        <div class="container mx-auto px-4 space-y-3">
            <a href="/" class="block py-2 text-gray-900 font-semibold text-lg hover:text-red-600 transition-colors duration-200">TRANG CHỦ</a>
            
            <!-- Mobile Products Submenu -->
            <div class="relative">
                <button id="mobile-products-button" class="w-full flex justify-between items-center py-2 text-gray-900 font-semibold text-lg hover:text-red-600 transition-colors duration-200">
                    <span>SẢN PHẨM</span>
                    <svg class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="mobile-products-menu" class="hidden pl-4 mt-1 space-y-2">
                    <a href="/products/men" class="block py-1.5 text-gray-700 hover:text-red-600">Giày Nam</a>
                    <a href="/products/women" class="block py-1.5 text-gray-700 hover:text-red-600">Giày Nữ</a>
                    <a href="/products/sports" class="block py-1.5 text-gray-700 hover:text-red-600">Giày Thể Thao</a>
                    <a href="/products/sneakers" class="block py-1.5 text-gray-700 hover:text-red-600">Sneakers</a>
                    <a href="/new-arrivals" class="block py-1.5 text-gray-700 hover:text-red-600">Hàng Mới Về</a>
                    <div class="border-t border-gray-200 mt-2 pt-2">
                        <h4 class="font-medium text-gray-900 mb-1">Thương hiệu</h4>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="/brands/nike" class="text-sm text-gray-700 hover:text-red-600">Nike</a>
                            <a href="/brands/adidas" class="text-sm text-gray-700 hover:text-red-600">Adidas</a>
                            <a href="/brands/jordan" class="text-sm text-gray-700 hover:text-red-600">Jordan</a>
                            <a href="/brands/puma" class="text-sm text-gray-700 hover:text-red-600">Puma</a>
                            <a href="/brands/converse" class="text-sm text-gray-700 hover:text-red-600">Converse</a>
                            <a href="/brands/vans" class="text-sm text-gray-700 hover:text-red-600">Vans</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <a href="/sale" class="block py-2 text-gray-900 font-semibold text-lg hover:text-red-600 transition-colors duration-200">KHUYẾN MÃI</a>
            <a href="/new-arrivals" class="block py-2 text-gray-900 font-semibold text-lg hover:text-red-600 transition-colors duration-200">HÀNG MỚI</a>
            
            <!-- Mobile Account Links -->
            <div class="pt-2 border-t border-gray-200 mt-2">
                <a href="/account" class="block py-2 text-gray-900 font-semibold text-lg hover:text-red-600 transition-colors duration-200">TÀI KHOẢN</a>
                <a href="/wishlist" class="block py-2 text-gray-900 font-semibold text-lg hover:text-red-600 transition-colors duration-200">YÊU THÍCH (3)</a>
                <a href="/cart" class="block py-2 text-gray-900 font-semibold text-lg hover:text-red-600 transition-colors duration-200">GIỎ HÀNG (5)</a>
            </div>
            
            <!-- Mobile Search -->
            <form action="/search" method="GET" class="mt-3">
                <div class="relative">
                    <input type="text" name="q" placeholder="Tìm kiếm sản phẩm..." class="w-full border border-gray-300 rounded-full py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <button type="submit" class="absolute left-3 top-2.5">
                        <img src="{{ asset('assets/icons/icon_search.png') }}" alt="Search" class="h-4 w-4">
                    </button>
                </div>
            </form>
        </div>
    </div>
</header>