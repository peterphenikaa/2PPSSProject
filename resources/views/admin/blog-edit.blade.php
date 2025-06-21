<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard - 2PSS Sneakers</title>
    @vite(['resources/css/app.css', 'resources/css/createproduct.css','resources/css/dashboard.css'])
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
</head>

<body class="bg-gray-50" style="font-family: 'Rubik', sans-serif;">
    <x-sidebar />
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header Section -->
        <header>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center text-sm text-gray-500 mb-1">
                        <a href="/admin/dashboard" class="hover:text-indigo-600 transition-colors">Dashboard</a>
                        <span class="mx-2">/</span>
                        <a href="{{ route('admin.blog.index') }}" class="hover:text-indigo-600 transition-colors">Blog</a>
                        <span class="mx-2">/</span>
                        <span class="text-indigo-600">Sửa bài viết</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-2">
                            <span class="material-icons-round text-indigo-600 bg-indigo-50 p-2 rounded-full shadow-sm">edit</span>
                            Sửa bài viết blog
                        </h1>
                    </div>
                    <p class="text-gray-500 mt-1.5 text-sm md:text-base">Chỉnh sửa nội dung bài viết hiện có</p>
                </div>
                <div class="relative flex items-center gap-4">
                    <button id="helpBtnBlogEdit" class="p-2 rounded-full hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-all shadow-sm">
                        <span class="material-icons-round">help_outline</span>
                    </button>
                    <!-- Popover hướng dẫn sử dụng -->
                    <div id="helpPopoverBlogEdit" class="hidden absolute top-full right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 p-4 z-50">
                        <h3 class="text-md font-bold mb-2 text-indigo-700 flex items-center gap-2">
                            <span class="material-icons-round">help_outline</span> Hướng dẫn sửa bài viết
                        </h3>
                        <ul class="list-disc pl-5 text-gray-700 space-y-1 text-sm">
                            <li>Chỉnh sửa tiêu đề, nội dung hoặc trạng thái bài viết.</li>
                            <li>Thay đổi ảnh đại diện mới hoặc giữ nguyên ảnh cũ.</li>
                            <li>Nhấn "Cập nhật bài viết" để lưu thay đổi.</li>
                        </ul>
                        <div class="text-gray-500 text-xs mt-3 border-t pt-2">
                            Cần hỗ trợ? Liên hệ <span class="font-semibold">support@2pss.vn</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Blog Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information Section -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <span class="section-icon material-icons-round">info</span>
                            Nội dung bài viết
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <label for="title" class="form-label">Tiêu đề bài viết</label>
                                <input type="text" name="title" id="title" class="form-input" placeholder="Ví dụ: Xu hướng giày sneaker 2025" required value="{{ old('title', $blog->title) }}">
                            </div>

                            <div>
                                <label for="content" class="form-label">Nội dung bài viết</label>
                                <textarea name="content" id="content" rows="8" class="form-input" placeholder="Nhập nội dung bài viết..." required>{{ old('content', $blog->content) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Attributes -->
                <div class="space-y-6">
                    <!-- Blog Attributes Section -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <span class="section-icon material-icons-round">style</span>
                            Thuộc tính bài viết
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <label for="status" class="form-label">Trạng thái</label>
                                <select name="status" id="status" class="form-input">
                                    <option value="draft" {{ $blog->status == 'draft' ? 'selected' : '' }}>Nháp</option>
                                    <option value="published" {{ $blog->status == 'published' ? 'selected' : '' }}>Công khai</option>
                                </select>
                            </div>

                            <div>
                                <label for="image" class="form-label">Ảnh đại diện</label>
                                <div id="current-image-blog" class="mb-2 flex flex-col items-center">
                                    @if($blog->image)
                                        <img src="{{ asset((str_starts_with($blog->image, 'blog_images/') || str_starts_with($blog->image, 'public/')) ? 'storage/' . $blog->image : 'images/' . $blog->image) }}" 
                                             alt="Ảnh hiện tại" 
                                             class="h-24 rounded shadow border">
                                        <div class="text-xs text-gray-600 mt-1">Ảnh đã tải lên: {{ basename($blog->image) }}</div>
                                    @endif
                                </div>
                                <div class="image-upload">
                                    <div class="space-y-1 text-center">
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                                <span>Tải ảnh lên</span>
                                                <input id="image" name="image" type="file" class="sr-only" accept="image/*" onchange="previewUpdateBlogImage(event)">
                                            </label>
                                            <p class="pl-1">hoặc kéo thả tại đây</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, JPEG tối đa 5MB</p>
                                        <div id="preview-image-update-blog" class="mt-2 flex justify-center"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="form-section">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="submit" class="btn-primary">
                                <span class="material-icons-round">save</span>
                                Cập nhật bài viết
                            </button>
                            <a href="{{ route('admin.blog.index') }}" class="btn-secondary">
                                <span class="material-icons-round">close</span>
                                Hủy bỏ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

    <script>
        const helpBtnBlogEdit = document.getElementById('helpBtnBlogEdit');
        const helpPopoverBlogEdit = document.getElementById('helpPopoverBlogEdit');

        if (helpBtnBlogEdit && helpPopoverBlogEdit) {
            helpBtnBlogEdit.addEventListener('click', (event) => {
                event.stopPropagation();
                helpPopoverBlogEdit.classList.toggle('hidden');
            });

            document.addEventListener('click', (event) => {
                if (!helpPopoverBlogEdit.contains(event.target) && !helpBtnBlogEdit.contains(event.target)) {
                    helpPopoverBlogEdit.classList.add('hidden');
                }
            });

            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    helpPopoverBlogEdit.classList.add('hidden');
                }
            });
        }

        function previewUpdateBlogImage(event) {
            const preview = document.getElementById('preview-image-update-blog');
            const current = document.getElementById('current-image-blog');
            preview.innerHTML = '';
            if (current) current.style.display = 'none';
            const file = event.target.files[0];
            if (file) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.className = 'mx-auto rounded shadow border mt-2';
                img.style.maxWidth = '120px';
                img.style.maxHeight = '120px';
                preview.appendChild(img);
                // Hiển thị tên file đã chọn
                const fileName = document.createElement('div');
                fileName.className = 'text-xs text-gray-600 mt-1';
                fileName.innerText = 'Đã chọn: ' + file.name;
                preview.appendChild(fileName);
            }
        }
    </script>
</body>
</html>