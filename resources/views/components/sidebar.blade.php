<aside class="sidebar bg-white shadow-md w-64 h-screen fixed left-0 top-0 flex flex-col" style="font-family: 'Rubik', Arial, Helvetica, sans-serif;">
    <!-- Logo và tên ứng dụng -->
    <div class="p-6 border-b border-gray-200 flex items-center space-x-3">
        <img src="{{ asset('images/2PSS SNEAKERSS.png') }}" alt="2PSS Sneakers" class="h-8">
        <span class="text-xl font-bold text-gray-800">2PSS Admin</span>
    </div>

    <!-- Menu điều hướng -->
    <nav class="p-4 space-y-2 flex-1">
        <a href="/" class="flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100 font-medium">
            <span class="material-icons-round mr-3 text-gray-700">home</span> Về trang chính
        </a>
        <a href="/admin/dashboard" class="flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100 font-medium">
            <span class="material-icons-round mr-3 text-gray-700">dashboard</span> Tổng quan
        </a>
        <a href="/admin/orders"
            class="flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-800 font-medium">
            <span class="material-icons-round mr-3 text-gray-500">receipt_long</span> Đơn hàng
        </a>
        <a href="/admin/products"
            class="flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-800 font-medium">
            <span class="material-icons-round mr-3 text-gray-500">category</span> Sản phẩm
        </a>
        <a href="/admin/users"
            class="flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-800 font-medium">
            <span class="material-icons-round mr-3 text-gray-500">group</span> Khách hàng
        </a>
        <a href="{{ route('admin.blog.index') }}"
            class="flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-800 font-medium">
            <span class="material-icons-round mr-3 text-gray-500">article</span> Blog
        </a>
        <a href="/admin/admins"
            class="flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-800 font-medium">
            <span class="material-icons-round mr-3 text-gray-500">admin_panel_settings</span> Quản trị viên
        </a>
    </nav>

    <!-- Thông tin user -->
    <div class="p-4 border-t border-gray-200 mt-auto">
        <div class="flex items-center space-x-3 mb-4">
            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                <span class="material-icons-round text-gray-600">person</span>
            </div>
            <div>
                <div class="font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="text-xs text-gray-500">Quản trị viên</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                class="w-full flex items-center justify-center space-x-2 bg-gray-100 hover:bg-gray-200 text-gray-800 p-2 rounded-lg font-medium transition-colors">
                <span class="material-icons-round text-sm">logout</span>
                <span>Đăng xuất</span>
            </button>
        </form>
    </div>
</aside>
