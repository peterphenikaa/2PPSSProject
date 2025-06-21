<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tạo sản phẩm mới - 2PSS Sneakers Admin</title>
    @vite(['resources/css/app.css', 'resources/css/createproduct.css', 'resources/css/dashboard.css'])
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
                        <a href="/admin/products" class="hover:text-indigo-600 transition-colors">Sản phẩm</a>
                        <span class="mx-2">/</span>
                        <span class="text-indigo-600">Tạo mới</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-2">
                            <span
                                class="material-icons-round text-indigo-600 bg-indigo-50 p-2 rounded-full shadow-sm">add</span>
                            Cập nhật sản phẩm mới
                        </h1>
                    </div>
                    <p class="text-gray-500 mt-1.5 text-sm md:text-base">Cập nhật sản phẩm giày mới vào danh mục bán
                        hàng</p>
                </div>
                <div class="relative flex items-center gap-2">
                    <button id="helpBtnUpdateProduct"
                        class="p-2 rounded-full hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-all shadow-sm">
                        <span class="material-icons-round">help_outline</span>
                    </button>
                    <!-- Popover hướng dẫn sử dụng -->
                    <div id="helpPopoverUpdateProduct" class="hidden absolute top-full right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 p-4 z-50">
                        <h3 class="text-md font-bold mb-2 text-indigo-700 flex items-center gap-2">
                            <span class="material-icons-round">help_outline</span> Hướng dẫn cập nhật
                        </h3>
                        <ul class="list-disc pl-5 text-gray-700 space-y-1 text-sm">
                            <li>Chỉnh sửa các thông tin cần thiết của sản phẩm.</li>
                            <li>Để thay đổi ảnh, hãy chọn một file ảnh mới.</li>
                            <li>Nhấn "Lưu sản phẩm" để hoàn tất cập nhật.</li>
                        </ul>
                        <div class="text-gray-500 text-xs mt-3 border-t pt-2">
                            Cần hỗ trợ? Liên hệ <span class="font-semibold">support@2pss.vn</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="form-section">
                        <h2 class="section-title"><span class="section-icon material-icons-round">info</span>Thông tin
                            cơ bản</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="form-label">Tên sản phẩm</label>
                                <input type="text" name="name" id="name" class="form-input"
                                    value="{{ old('name', $product->name) }}" required>
                            </div>
                            <div>
                                <label for="description" class="form-label">Mô tả sản phẩm</label>
                                <textarea name="description" id="description" rows="4" class="form-input" required>{{ old('description', $product->description) }}</textarea>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="price" class="form-label">Giá bán (VND)</label>
                                    <input type="number" name="price" id="price" class="form-input"
                                        value="{{ old('price', $product->price) }}" min="0" required>
                                </div>
                                <div>
                                    <label for="stock" class="form-label">Số lượng trong kho</label>
                                    <input type="number" name="stock" id="stock" class="form-input"
                                        value="{{ old('stock', $product->stock) }}" min="0" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Images -->
                    <div class="form-section">
                        <h2 class="section-title"><span class="section-icon material-icons-round">image</span>Hình ảnh
                            sản phẩm</h2>
                        <div class="space-y-4">
                            <div id="current-image-product" class="mb-2 flex flex-col items-center">
                                @if ($product->image)
                                    <img src="{{ asset(str_starts_with($product->image, 'products/') ? 'storage/' . $product->image : 'images/' . $product->image) }}" alt="Ảnh hiện tại" class="h-24 rounded shadow">
                                    <div class="text-xs text-gray-600 mt-1">Ảnh đã tải lên: {{ basename($product->image) }}</div>
                                @endif
                            </div>
                            <div>
                                <label for="image" class="form-label">Ảnh mới (nếu muốn thay)</label>
                                <input id="image" name="image" type="file" class="form-input" accept="image/*" onchange="previewUpdateProductImage(event)">
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG tối đa 5MB</p>
                                <div id="preview-image-update-product" class="mt-2 flex justify-center"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <div class="form-section">
                        <h2 class="section-title"><span class="section-icon material-icons-round">style</span>Thuộc tính
                            sản phẩm</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="brand" class="form-label">Thương hiệu</label>
                                <input type="text" name="brand" id="brand" class="form-input"
                                    value="{{ old('brand', $product->brand) }}">
                            </div>
                            <div>
                                <label for="category" class="form-label">Danh mục</label>
                                <input type="text" name="category" id="category" class="form-input"
                                    value="{{ old('category', $product->category) }}">
                            </div>
                            <div>
                                <label for="gender" class="form-label">Giới tính</label>
                                <select name="gender" id="gender" class="form-input">
                                    <option value="unisex"
                                        {{ old('gender', $product->gender) == 'unisex' ? 'selected' : '' }}>Unisex
                                    </option>
                                    <option value="male"
                                        {{ old('gender', $product->gender) == 'male' ? 'selected' : '' }}>Nam</option>
                                    <option value="female"
                                        {{ old('gender', $product->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
                                </select>
                            </div>
                            <div>
                                <label for="colorway" class="form-label">Màu sắc</label>
                                <input type="text" name="colorway" id="colorway" class="form-input"
                                    value="{{ old('colorway', $product->colorway) }}">
                            </div>
                            <div>
                                <label for="available_sizes" class="form-label">Kích cỡ có sẵn</label>
                                @php
                                    $sizes =
                                        old('available_sizes') ??
                                        (is_array($product->available_sizes)
                                            ? implode(',', $product->available_sizes)
                                            : $product->available_sizes);
                                @endphp
                                <input type="text" name="available_sizes" id="available_sizes" class="form-input"
                                    value="{{ $sizes }}">

                            </div>
                        </div>
                    </div>
                    <!-- Action -->
                    <div class="form-section">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="submit" class="btn-primary">
                                <span class="material-icons-round">save</span>
                                Lưu sản phẩm
                            </button>
                            <a href="/admin/products" class="btn-secondary">
                                <span class="material-icons-round">close</span>
                                Hủy bỏ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</body>

<script>
    const helpBtnUpdateProduct = document.getElementById('helpBtnUpdateProduct');
    const helpPopoverUpdateProduct = document.getElementById('helpPopoverUpdateProduct');

    if (helpBtnUpdateProduct && helpPopoverUpdateProduct) {
        helpBtnUpdateProduct.addEventListener('click', (event) => {
            event.stopPropagation();
            helpPopoverUpdateProduct.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            if (!helpPopoverUpdateProduct.contains(event.target) && !helpBtnUpdateProduct.contains(event.target)) {
                helpPopoverUpdateProduct.classList.add('hidden');
            }
        });

        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                helpPopoverUpdateProduct.classList.add('hidden');
            }
        });
    }

function previewUpdateProductImage(event) {
    const preview = document.getElementById('preview-image-update-product');
    const current = document.getElementById('current-image-product');
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

</html>
