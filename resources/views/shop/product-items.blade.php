<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết sản phẩm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/css/product-items.css')
    @vite('resources/js/product-items.js')
</head>

<body>
    @include('layouts.header')

    <main class="bg-white">
        <!-- Product Breadcrumb -->
        <div class="border-b border-gray-200 py-4 px-6">
            <div class="container mx-auto text-sm text-gray-600">
                <span class="hover:text-black cursor-pointer">Trang chủ</span> /
                <span class="hover:text-black cursor-pointer">{{ ucfirst($product->gender) }}</span> /
                <span class="hover:text-black cursor-pointer">{{ $product->category }}</span> /
                <span class="text-black">{{ $product->name }}</span>
            </div>
        </div>

        <!-- Product Main Section -->
        <div class="container mx-auto px-6 py-10">
            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Product Images -->
                <div class="w-full lg:w-1/2">
                    <div class="product-gallery">
                        <!-- Main Image -->
                        <img src="{{ asset('images/' . $mainImage) }}" alt="{{ $product->name }}" loading="lazy"
                            class="w-full">
                    </div>
                </div>

                <!-- Product Info -->
                <div class="w-full lg:w-1/2">
                    <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
                    <p class="text-gray-600 mb-4">{{ $product->category }}</p>
                    <p class="text-2xl font-bold mb-6">{{ number_format($product->price) }}₫</p>

                    <div class="mb-8">
                        <h3 class="font-bold mb-3">Chọn size</h3>
                        <p class="text-sm text-gray-600 mb-4">Giày chạy size lớn, khuyến nghị chọn size nhỏ hơn 1 size
                            so với bình thường</p>

                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($product->available_sizes as $size)
                                <div class="size-option cursor-pointer border px-3 py-1 rounded" data-size="{{ $size }}">
                                    {{ $size }}
                                </div>
                            @endforeach
                        </div>

                        <div class="flex flex-col gap-2 mb-4">
                            <button
                                class="buy-now-btn w-full bg-black text-white py-3 rounded-md hover:bg-gray-800 transition duration-200 font-medium">
                                Mua ngay
                            </button>
                            <button
                                class="add-to-cart-btn w-full bg-white border border-black text-black py-3 rounded-md hover:bg-gray-100 transition duration-200 font-medium"
                                data-product-id="{{ $product->id }}">
                                Thêm vào giỏ hàng
                            </button>
                        </div>

                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Miễn phí vận chuyển cho đơn hàng từ 500.000₫</span>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="font-bold mb-2">Hướng dẫn chọn size</h4>
                            <div class="overflow-x-auto">
                                <table class="size-guide-table text-sm w-full">
                                    <tr>
                                        <th>Size (EU)</th>
                                        <td>36</td>
                                        <td>37</td>
                                        <td>38</td>
                                        <td>39</td>
                                        <td>40</td>
                                        <td>41</td>
                                        <td>42</td>
                                        <td>43</td>
                                        <td>44</td>
                                    </tr>
                                    <tr>
                                        <th>Chiều dài chân (cm)</th>
                                        <td>23</td>
                                        <td>23.5</td>
                                        <td>24</td>
                                        <td>25</td>
                                        <td>25.5</td>
                                        <td>26</td>
                                        <td>26.5</td>
                                        <td>27</td>
                                        <td>28</td>
                                    </tr>
                                    <tr>
                                        <th>Khuyến nghị</th>
                                        <td>Nữ</td>
                                        <td>Nữ</td>
                                        <td>Nữ/Unisex</td>
                                        <td>Unisex</td>
                                        <td>Unisex</td>
                                        <td>Nam</td>
                                        <td>Nam</td>
                                        <td>Nam</td>
                                        <td>Nam</td>
                                    </tr>
                                </table>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">* Lưu ý: Kích thước có thể thay đổi tùy thuộc vào kiểu
                                dáng giày và thương hiệu</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <p class="text-gray-700 mb-4">
                            {{ $product->description }}
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1 mb-4">
                            <li>Màu sắc: {{ $product->colorway }}</li>
                            <li>Mã sản phẩm: {{ $product->id }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Product Details Tabs -->
            <div class="border-t border-gray-200 mt-12 pt-8">
                <div class="flex gap-8 border-b border-gray-200">
                    <button class="tab-button pb-4 font-medium border-b-2 border-black" data-tab="size-fit">Size &
                        Fit</button>
                    <button class="tab-button pb-4 font-medium text-gray-500" data-tab="shipping-return">Vận chuyển &
                        Đổi trả</button>
                </div>

                <div id="size-fit" class="tab-content py-6">
                    <h3 class="font-bold mb-4">Hướng dẫn chọn size</h3>
                    <ul class="list-disc pl-5 space-y-2 text-gray-700">
                        <li>Giày chạy size lớn, khuyến nghị chọn size nhỏ hơn 1 size so với bình thường</li>
                        <li>Kiểu dáng tiêu chuẩn</li>
                        <li>Dây buộc cổ điển</li>
                        <li>Cổ giày có đệm êm ái</li>
                        <li>Phù hợp cho nhiều hoạt động từ thể thao đến đi chơi</li>
                        <li>Chất liệu da cao cấp, bền đẹp theo thời gian</li>
                    </ul>
                </div>

                <div id="shipping-return" class="tab-content py-6 hidden">
                    <h3 class="font-bold mb-4">Chính sách vận chuyển & đổi trả</h3>
                    <div class="space-y-4 text-gray-700">
                        <div>
                            <h4 class="font-semibold mb-2">1. Vận chuyển</h4>
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Miễn phí vận chuyển cho đơn hàng từ 500.000₫</li>
                                <li>Giao hàng toàn quốc trong 2-5 ngày làm việc</li>
                                <li>Hỗ trợ giao hàng nhanh trong nội thành (phí 30.000₫)</li>
                                <li>Theo dõi đơn hàng trực tuyến sau khi đặt hàng</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2">2. Đổi trả hàng</h4>
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Đổi trả miễn phí trong vòng 30 ngày nếu sản phẩm còn nguyên tag, hóa đơn và chưa qua
                                    sử dụng</li>
                                <li>Chỉ áp dụng đổi size/ màu (nếu còn hàng) hoặc hoàn tiền</li>
                                <li>Sản phẩm sale chỉ được đổi sang sản phẩm khác có giá trị tương đương hoặc cao hơn
                                </li>
                                <li>Không áp dụng đổi trả với sản phẩm đã qua sử dụng hoặc bị hư hỏng do người dùng</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2">3. Liên hệ</h4>
                            <p>Mọi thắc mắc về đơn hàng vui lòng liên hệ hotline 1900 1234 hoặc email support@hike.vn
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Images Section -->
            <div class="additional-images-section">
                <h3 class="text-xl font-bold mb-4">Ảnh liên quan</h3>
                <div class="additional-images-grid">
                    @foreach($additionalImages as $image)
                        <div class="additional-image-item">
                            <img src="{{ asset('images/' . $image->image_path) }}" alt="Ảnh phụ {{ $product->name }}"
                                loading="lazy">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Related Products Section -->
            <div class="mt-16">
                <h2 class="text-2xl font-bold mb-6">Sản phẩm tương tự</h2>
                @if($relatedProducts->count() > 0)
                    <div class="related-products grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $related)
                            <a href="{{ route('products.show', $related->id) }}" class="product-card block hover:no-underline">
                                <!-- Main Product Image -->
                                <div class="bg-gray-100 rounded-lg overflow-hidden mb-2 aspect-square">
                                    <img src="{{ asset('images/' . ($related->image ?? 'default.jpg')) }}"
                                        alt="{{ $related->name }}" class="w-full h-full object-cover" loading="lazy">
                                </div>

                                <!-- Product Info -->
                                <h4 class="font-medium text-gray-900 hover:text-black">{{ $related->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $related->category }}</p>
                                <p class="font-bold text-gray-900">{{ number_format($related->price) }}₫</p>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Hiện không có sản phẩm nào khác</p>
                @endif
            </div>
        </div>
    </main>

    <!-- Order Popup -->
    <div class="popup-overlay" id="order-popup">
        <div class="popup-container">
            <div class="popup-header">
                <h3 class="popup-title">Thông tin đặt hàng</h3>
                <button class="popup-close" id="close-popup">&times;</button>
            </div>
            <form id="order-form" action="{{ route('orders.store') }}" method="POST" class="address-form">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="size" id="size_popup_input">
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="price" value="{{ $product->price }}">

                <div class="form-group">
                    <label for="recipient_name">Họ tên người nhận:</label>
                    <input type="text" id="recipient_name" name="recipient_name" class="w-full border p-2 rounded" required>
                </div>
                
                <div class="form-group">
                    <label for="recipient_phone">Số điện thoại:</label>
                    <input type="text" id="recipient_phone" name="recipient_phone" class="w-full border p-2 rounded" required>
                </div>
                
                <div class="form-group">
                    <label for="province">Tỉnh/Thành phố:</label>
                    <select id="province" name="province" class="w-full border p-2 rounded" required>
                        <option value="">Chọn tỉnh/thành phố</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="district">Quận/Huyện:</label>
                    <select id="district" name="district" class="w-full border p-2 rounded" required disabled>
                        <option value="">Chọn quận/huyện</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="ward">Phường/Xã:</label>
                    <select id="ward" name="ward" class="w-full border p-2 rounded" required disabled>
                        <option value="">Chọn phường/xã</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="address_detail">Địa chỉ chi tiết:</label>
                    <input type="text" id="address_detail" name="address_detail" class="w-full border p-2 rounded" required>
                </div>
                
                <div class="form-group">
                    <label for="payment_method">Phương thức thanh toán:</label>
                    <select id="payment_method" name="payment_method" class="w-full border p-2 rounded">
                        <option value="cod">Thanh toán khi nhận hàng</option>
                        <option value="momo_qr">Thanh toán bằng Momo QR</option>
                    </select>
                </div>
                
                <button type="submit" id="submit-btn" class="w-full bg-black text-white py-3 rounded-md">
                    <span class="btn-text">Đặt hàng ngay</span>
                    <span class="loading hidden">Đang xử lý...</span>
                </button>
            </form>
        </div>
    </div>

    @include('layouts.footer')

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const isLoggedIn = @json(auth()->check());
            let selectedSize = null;

            // --- DOM Elements ---
            const sizeOptions = document.querySelectorAll('.size-option');
            const buyNowBtn = document.querySelector('.buy-now-btn');
            const addToCartBtn = document.querySelector('.add-to-cart-btn');
            const orderPopup = document.getElementById('order-popup');
            const closePopup = document.getElementById('close-popup');
            const orderForm = document.getElementById('order-form');
            const sizePopupInput = document.getElementById('size_popup_input');

            // --- Event Handlers ---
            
            // 1. Size Selection
            sizeOptions.forEach(option => {
                option.addEventListener('click', () => {
                    sizeOptions.forEach(o => o.classList.remove('bg-black', 'text-white'));
                    option.classList.add('bg-black', 'text-white');
                    selectedSize = option.dataset.size;
                });
            });

            // 2. "Buy Now" Button
            if (buyNowBtn) {
                buyNowBtn.addEventListener('click', () => {
                    if (!isLoggedIn) {
                        alert("Vui lòng đăng nhập để mua hàng.");
                        window.location.href = "{{ route('login') }}";
                        return;
                    }
                    if (!selectedSize) {
                        alert("Vui lòng chọn size trước khi mua hàng.");
                        return;
                    }
                    sizePopupInput.value = selectedSize;
                    orderPopup.classList.add('active');
                });
            }
            
            // 3. "Add to Cart" Button
            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', () => {
                    if (!isLoggedIn) {
                        alert("Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng");
                        window.location.href = "{{ route('login') }}";
                        return;
                    }
                    if (!selectedSize) {
                        alert("Vui lòng chọn size trước khi thêm vào giỏ hàng.");
                        return;
                    }
                    
                    const productId = addToCartBtn.dataset.productId;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    const formData = new FormData();
                    formData.append('product_id', productId);
                    formData.append('size', selectedSize);
                    formData.append('quantity', 1);

                    fetch("{{ route('cart.add') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.success);
                        } else {
                            alert('Có lỗi xảy ra khi thêm vào giỏ hàng!');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Có lỗi xảy ra khi thêm vào giỏ hàng!');
                    });
                });
            }

            // 4. Popup Handling (Close)
            if (closePopup) {
                closePopup.addEventListener('click', () => orderPopup.classList.remove('active'));
            }
            if (orderPopup) {
                orderPopup.addEventListener('click', (e) => {
                    if (e.target === orderPopup) {
                        orderPopup.classList.remove('active');
                    }
                });
            }

            // 5. Order Form Submission
            if(orderForm) {
                orderForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const submitBtn = this.querySelector('#submit-btn');
                    const loading = submitBtn.querySelector('.loading');
                    const btnText = submitBtn.querySelector('.btn-text');
                    
                    submitBtn.disabled = true;
                    if (btnText) btnText.classList.add('hidden');
                    if (loading) loading.classList.remove('hidden');

                    fetch(this.action, {
                        method: 'POST',
                        body: new FormData(this),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.redirect_url) {
                            window.location.href = data.redirect_url;
                        } else {
                             alert(data.success || 'Đặt hàng thành công!');
                             window.location.href = '/';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Đã có lỗi xảy ra. Vui lòng thử lại.');
                        submitBtn.disabled = false;
                        if (btnText) btnText.classList.remove('hidden');
                        if (loading) loading.classList.add('hidden');
                    });
                });
            }

            // --- Address API ---
            loadProvinces();
            document.getElementById('province').addEventListener('change', function() {
                const provinceId = this.value;
                const districtSelect = document.getElementById('district');
                if (provinceId) {
                    districtSelect.disabled = false;
                    loadDistricts(provinceId);
                } else {
                    districtSelect.disabled = true;
                    districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
                    document.getElementById('ward').disabled = true;
                    document.getElementById('ward').innerHTML = '<option value="">Chọn phường/xã</option>';
                }
            });
            document.getElementById('district').addEventListener('change', function() {
                const districtId = this.value;
                const wardSelect = document.getElementById('ward');
                if (districtId) {
                    wardSelect.disabled = false;
                    loadWards(districtId);
                } else {
                    wardSelect.disabled = true;
                    wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
                }
            });
        });
        
        // --- API Functions ---
        function loadProvinces() {
            fetch('https://provinces.open-api.vn/api/')
                .then(response => response.json())
                .then(provinces => {
                    const provinceSelect = document.getElementById('province');
                    provinces.forEach(province => {
                        const option = document.createElement('option');
                        option.value = province.code;
                        option.textContent = province.name;
                        provinceSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error loading provinces:', error));
        }
        function loadDistricts(provinceId) {
            fetch(`https://provinces.open-api.vn/api/p/${provinceId}?depth=2`)
                .then(response => response.json())
                .then(province => {
                    const districtSelect = document.getElementById('district');
                    districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
                    province.districts.forEach(district => {
                        const option = document.createElement('option');
                        option.value = district.code;
                        option.textContent = district.name;
                        districtSelect.appendChild(option);
                    });
                    document.getElementById('ward').disabled = true;
                    document.getElementById('ward').innerHTML = '<option value="">Chọn phường/xã</option>';
                })
                .catch(error => console.error('Error loading districts:', error));
        }
        function loadWards(districtId) {
            fetch(`https://provinces.open-api.vn/api/d/${districtId}?depth=2`)
                .then(response => response.json())
                .then(district => {
                    const wardSelect = document.getElementById('ward');
                    wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
                    district.wards.forEach(ward => {
                        const option = document.createElement('option');
                        option.value = ward.code;
                        option.textContent = ward.name;
                        wardSelect.appendChild(option);
                    });
                    wardSelect.disabled = false;
                })
                .catch(error => console.error('Error loading wards:', error));
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const target = document.getElementById(tab.dataset.tab);

                    // Deactivate all tabs
                    tabs.forEach(t => {
                        t.classList.remove('border-black', 'text-black');
                        t.classList.add('text-gray-500');
                    });

                    // Deactivate all content
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Activate the clicked tab and its content
                    tab.classList.add('border-black', 'text-black');
                    tab.classList.remove('text-gray-500');
                    target.classList.remove('hidden');
                });
            });
        });
    </script>

    @section('meta_title', $product->name . ' - 2PSS Sneaker')
    @section('meta_description', Str::limit(strip_tags($product->description), 150))
    @section('meta_image', asset('images/' . $product->image))
</body>
</html>