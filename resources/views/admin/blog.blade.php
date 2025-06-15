<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard - 2PSS Sneakers</title>
    @vite(['resources/css/app.css', 'resources/css/dashboard.css'])

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
</head>

<body></body>
    <x-sidebar />
    <!-- Main Content -->
    <div class="main-content ml-64 p-6">
        <!-- Header -->
        <header class="mb-8 shadow-sm bg-white rounded-xl px-6 py-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center text-sm text-gray-500 mb-1">
                        <a href="/admin/dashboard" class="hover:text-indigo-600">Dashboard</a>
                        <span class="mx-2">/</span>
                        <span class="text-indigo-600">Blog</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-2">
                        <span class="material-icons-round text-indigo-600">article</span>
                        Quản lý blog
                    </h1>
                    <p class="text-gray-600 mt-1 text-sm md:text-base">Xem và quản lý tất cả bài viết blog của cửa hàng
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    <form action="{{ route('admin.blog.index') }}" method="GET" class="relative hidden md:block">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Tìm kiếm tiêu đề..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 w-64">
                        <span class="material-icons-round absolute left-3 top-2.5 text-gray-400">search</span>
                        @if(request('search'))
                            <a href="{{ route('admin.blog.index') }}" class="absolute right-3 top-2.5 text-gray-400 hover:text-red-500" title="Xóa bộ lọc">
                                <span class="material-icons-round">close</span>
                            </a>
                        @endif
                    </form>
                    <div class="flex items-center gap-2">
                        <button id="helpBtnBlog" type="button"
                            class="p-2 rounded-full hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors"
                            style="cursor:pointer">
                            <span class="material-icons-round">help_outline</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>
        <!-- Modal hướng dẫn sử dụng -->
        <div id="helpModalBlog" class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-40"
            style="display:none;">
            <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6 relative animate-fade-in mx-auto mt-24">
                <button id="closeHelpModalBlog" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700">
                    <span class="material-icons-round">close</span>
                </button>
                <h2 class="text-xl font-bold mb-2 text-indigo-700 flex items-center gap-2">
                    <span class="material-icons-round">help_outline</span> Hướng dẫn sử dụng
                </h2>
                <ul class="list-disc pl-5 text-gray-700 space-y-1 mb-2">
                    <li>Tìm kiếm bài viết theo tiêu đề bằng ô tìm kiếm phía trên.</li>
                    <li>Nhấn nút <span class="material-icons-round text-sm align-middle">edit</span> để sửa bài viết.
                    </li>
                    <li>Nhấn nút <span class="material-icons-round text-sm align-middle text-red-600">delete</span> để
                        xóa bài viết (cần xác nhận).</li>
                    <li>Nhấn nút "Tạo" để thêm bài viết mới.</li>
                </ul>
                <div class="text-gray-500 text-sm mt-2">
                    Nếu cần hỗ trợ thêm, vui lòng liên hệ quản trị viên hệ thống.<br>
                    <span class="font-semibold">Hotline:</span> 0123 456 789<br>
                    <span class="font-semibold">Email:</span> support@2pss.vn
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200 mt-4">
            <div class="px-6 py-4 flex items-center justify-between border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Danh sách bài viết</h2>
                <a href="{{ route('admin.blog.create') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <span class="material-icons-round mr-2 align-middle" style="font-size: 22px;">add</span>
                    <span class="align-middle">Tạo</span>
                </a>
            </div>
            <div class="px-6 py-4">
                <!-- Hiển thị thông báo nếu có kết quả tìm kiếm -->
                @if(request('search'))
                    <div class="mb-4 text-sm text-gray-600">Kết quả tìm kiếm cho: <span class="font-semibold">"{{ request('search') }}"</span></div>
                @endif
            </div>
            <div class="overflow-x-auto" style="max-height: 70vh; overflow-y: auto;">
                <table class="order-table">
                    <thead>
                        <tr>
                            <th class="w-20">ID</th>
                            <th>Tiêu đề</th>
                            <th>Ảnh</th>
                            <th>Trạng thái</th>
                            <th class="w-20">Sửa</th>
                            <th class="w-20">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($blogs as $blog)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="font-medium text-gray-900">#{{ str_pad($blog->id, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td>{{ $blog->title }}</td>
                                <td>
                                    @if ($blog->image)
                                        <button type="button" class="show-image-btn" data-imgsrc="{{ asset((str_starts_with($blog->image, 'blog_images/') || str_starts_with($blog->image, 'public/')) ? 'storage/' . $blog->image : 'images/' . $blog->image) }}" title="Xem ảnh lớn" style="background:none;border:none;outline:none;cursor:pointer;">
                                            <span class="material-icons-round text-indigo-500" style="font-size:32px;">image</span>
                                        </button>
                                    @else
                                        <span class="material-icons-round text-gray-400" style="font-size:32px;">image_not_supported</span>
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="badge {{ $blog->status == 'published' ? 'bg-success' : 'bg-secondary' }}">{{ $blog->status }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.blog.edit', $blog->id) }}"
                                        class="text-indigo-600 hover:text-indigo-800 transition-colors">
                                        <span class="material-icons-round">edit</span>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.blog.destroy', $blog->id) }}" method="POST"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 transition-colors">
                                            <span class="material-icons-round">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                    Không có bài viết nào @if (request('search'))
                                        cho từ khóa "{{ request('search') }}"
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal xem ảnh lớn -->
    <div id="imageModal" style="display:none;position:fixed;z-index:9999;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.6);align-items:center;justify-content:center;">
        <div style="position:relative;max-width:90vw;max-height:90vh;display:flex;align-items:center;justify-content:center;">
            <button id="closeImageModal" style="position:absolute;top:-32px;right:-32px;background:#fff;border-radius:50%;border:none;width:40px;height:40px;box-shadow:0 2px 8px #0002;display:flex;align-items:center;justify-content:center;cursor:pointer;z-index:10;">
                <span class="material-icons-round text-gray-700" style="font-size:28px;">close</span>
            </button>
            <img id="modalImage" src="" alt="Blog Image" style="max-width:80vw;max-height:80vh;border-radius:12px;box-shadow:0 4px 32px #0005;" />
        </div>
    </div>
    <script>
        const helpBtnBlog = document.getElementById('helpBtnBlog');
        const helpModalBlog = document.getElementById('helpModalBlog');
        const closeHelpModalBlog = document.getElementById('closeHelpModalBlog');
        if (helpBtnBlog && helpModalBlog && closeHelpModalBlog) {
            helpBtnBlog.addEventListener('click', () => helpModalBlog.style.display = 'flex');
            closeHelpModalBlog.addEventListener('click', () => helpModalBlog.style.display = 'none');
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') helpModalBlog.style.display = 'none';
            });
        }
        document.querySelectorAll('.show-image-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('modalImage').src = this.getAttribute('data-imgsrc');
                document.getElementById('imageModal').style.display = 'flex';
            });
        });
        document.getElementById('closeImageModal').onclick = function() {
            document.getElementById('imageModal').style.display = 'none';
            document.getElementById('modalImage').src = '';
        };
        document.getElementById('imageModal').onclick = function(e) {
            if (e.target === this) {
                this.style.display = 'none';
                document.getElementById('modalImage').src = '';
            }
        };
    </script>
</body>

</html>
