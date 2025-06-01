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
                        <button class="relative p-2 rounded-full hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-all shadow-sm">
                            <span class="material-icons-round">notifications</span>
                            <span class="absolute top-0 right-0 h-2.5 w-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>
                        <button class="p-2 rounded-full hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-all shadow-sm">
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
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">₫</span>
                                        <input type="number" name="price" id="price" class="form-input pl-8" placeholder="1,000,000" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="stock" class="form-label">Số lượng trong kho</label>
                                    <input type="number" name="stock" id="stock" class="form-input" placeholder="100">
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
                                                <input id="image" name="image" type="file" class="sr-only" required>
                                            </label>
                                            <p class="pl-1">hoặc kéo thả tại đây</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, JPEG tối đa 5MB</p>
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
                                    <option value="male">Nam</option>
                                    <option value="female">Nữ</option>
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
    </div>
</body>
</html>