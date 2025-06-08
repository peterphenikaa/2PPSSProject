<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tạo sản phẩm mới - 2PSS Sneakers Admin</title>
    @vite(['resources/css/app.css', 'resources/css/createproduct.css','resources/css/dashboard.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
</head>

<body class="bg-gray-50">
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
                            <span class="material-icons-round text-indigo-600 bg-indigo-50 p-2 rounded-full shadow-sm">add</span>
                            Tạo sản phẩm mới
                        </h1>
                    </div>
                    <p class="text-gray-500 mt-1.5 text-sm md:text-base">Thêm sản phẩm giày mới vào danh mục bán hàng</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <button id="helpBtnCreateProduct" class="p-2 rounded-full hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-all shadow-sm">
                            <span class="material-icons-round">help_outline</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>
        <form action="{{ route('admin.products.create') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Product Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information Section -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <span class="section-icon material-icons-round">info</span>
                            Thông tin cơ bản
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="form-label">Tên sản phẩm</label>
                                <input type="text" name="name" id="name" class="form-input" placeholder="Ví dụ: Giày thể thao XYZ" required>
                            </div>

                            <div>
                                <label for="description" class="form-label">Mô tả sản phẩm</label>
                                <textarea name="description" id="description" rows="4" class="form-input" placeholder="Mô tả chi tiết về sản phẩm..." required></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="price" class="form-label">Giá bán (VND)</label>
                                    <div class="relative">
                                        <input type="number" name="price" id="price" class="form-input pl-8" placeholder="1,000,000" min="0" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="stock" class="form-label">Số lượng trong kho</label>
                                    <input type="number" name="stock" id="stock" class="form-input" placeholder="100" min="0" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Product Images Section -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <span class="section-icon material-icons-round">image</span>
                            Hình ảnh sản phẩm
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <label for="image" class="form-label">Ảnh chính</label>
                                <div class="image-upload">
                                    <div class="space-y-1 text-center">
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                                <span>Tải ảnh lên</span>
                                                <input id="image" name="image" type="file" class="sr-only" accept="image/*" onchange="previewProductImage(event)" required>
                                            </label>
                                            <p class="pl-1">hoặc kéo thả tại đây</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, JPEG tối đa 5MB</p>
                                        <div id="preview-image-product" class="mt-2 flex justify-center"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Attributes -->
                <div class="space-y-6">
                    <!-- Product Attributes Section -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <span class="section-icon material-icons-round">style</span>
                            Thuộc tính sản phẩm
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <label for="brand" class="form-label">Thương hiệu</label>
                                <input type="text" name="brand" id="brand" class="form-input" placeholder="Ví dụ: Nike, Adidas">
                            </div>

                            <div>
                                <label for="category" class="form-label">Danh mục</label>
                                <input type="text" name="category" id="category" class="form-input" placeholder="Ví dụ: Giày chạy bộ">
                            </div>

                            <div>
                                <label for="gender" class="form-label">Giới tính</label>
                                <select name="gender" id="gender" class="form-input">
                                    <option value="unisex">Unisex</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>

                            <div>
                                <label for="colorway" class="form-label">Màu sắc</label>
                                <input type="text" name="colorway" id="colorway" class="form-input" placeholder="Ví dụ: Đen/Trắng">
                            </div>

                            <div>
                                <label for="available_sizes" class="form-label">Kích cỡ có sẵn</label>
                                <input type="text" name="available_sizes" id="available_sizes" class="form-input" placeholder="Phân cách bằng dấu phẩy (38,39,40)">
                            </div>
                        </div>
                    </div>
                    <!-- Form Actions -->
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

        <!-- Modal hướng dẫn sử dụng -->
        <div id="helpModalCreateProduct" class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-40" style="display:none;">
            <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6 relative animate-fade-in mx-auto mt-24">
                <button id="closeHelpModalCreateProduct" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700">
                    <span class="material-icons-round">close</span>
                </button>
                <h2 class="text-xl font-bold mb-2 text-indigo-700 flex items-center gap-2">
                    <span class="material-icons-round">help_outline</span> Hướng dẫn tạo sản phẩm
                </h2>
                <ul class="list-disc pl-5 text-gray-700 space-y-1 mb-2">
                    <li>Điền đầy đủ thông tin sản phẩm: tên, mô tả, giá, số lượng, thương hiệu, danh mục, màu sắc, kích cỡ.</li>
                    <li>Chọn ảnh đại diện sản phẩm (bắt buộc).</li>
                    <li>Nhấn "Lưu sản phẩm" để hoàn tất tạo mới.</li>
                    <li>Các trường bắt buộc sẽ có dấu hiệu cảnh báo nếu bỏ trống.</li>
                </ul>
                <div class="text-gray-500 text-sm mt-2">
                    Nếu cần hỗ trợ thêm, vui lòng liên hệ quản trị viên hệ thống.<br>
                    <span class="font-semibold">Hotline:</span> 0123 456 789<br>
                    <span class="font-semibold">Email:</span> support@2pss.vn
                </div>
            </div>
        </div>
    </div>

    <script>
        const helpBtnCreateProduct = document.getElementById('helpBtnCreateProduct');
        const helpModalCreateProduct = document.getElementById('helpModalCreateProduct');
        const closeHelpModalCreateProduct = document.getElementById('closeHelpModalCreateProduct');
        if (helpBtnCreateProduct && helpModalCreateProduct && closeHelpModalCreateProduct) {
            helpBtnCreateProduct.addEventListener('click', () => helpModalCreateProduct.style.display = 'flex');
            closeHelpModalCreateProduct.addEventListener('click', () => helpModalCreateProduct.style.display = 'none');
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') helpModalCreateProduct.style.display = 'none';
            });
        }

        function previewProductImage(event) {
            const preview = document.getElementById('preview-image-product');
            preview.innerHTML = '';
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
            // Đảm bảo chỉ chọn 1 ảnh
            event.target.value = event.target.value;
        }
    </script>
</body>
</html>