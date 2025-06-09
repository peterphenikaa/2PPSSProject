<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết sản phẩm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        /* Custom CSS for product detail page */
        .product-gallery {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        
        .product-gallery img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 0.5rem;
        }
        
        .size-option {
            border: 1px solid #e5e7eb;
            padding: 0.5rem 1rem;
            text-align: center;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .size-option:hover, .size-option.selected {
            border-color: #000;
            background-color: #000;
            color: white;
        }
        
        .size-guide-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .size-guide-table th, .size-guide-table td {
            border: 1px solid #e5e7eb;
            padding: 0.5rem;
            text-align: center;
        }
        
        .customer-images {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }
        
        .customer-images img {
            width: 100%;
            height: auto;
            border-radius: 0.5rem;
        }
        
        .related-products {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }
        
        .product-card {
            transition: all 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* Rating stars */
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }
        .rating input {
            display: none;
        }
        .rating label {
            color: #ddd;
            font-size: 1.5rem;
            cursor: pointer;
        }
        .rating input:checked ~ label {
            color: #ffc107;
        }
        .rating label:hover,
        .rating label:hover ~ label {
            color: #ffc107;
        }

        /* Review section */
        .review {
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 0;
        }
        .review:last-child {
            border-bottom: none;
        }
    </style>
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
            <div class="flex gap-12">
                <!-- Product Images -->
                <div class="w-1/2">
    <div class="product-gallery">
        <!-- Ảnh chính -->
        <img src="{{ asset('images/' . $mainImage) }}" alt="{{ $product->name }}" loading="lazy">
        
        <!-- Các ảnh phụ -->
        @foreach($additionalImages as $image)
            @if($image)
                <img src="{{ asset('images/' . trim($image)) }}" alt="{{ $product->name }}" loading="lazy">
            @endif
        @endforeach
    </div>
</div>
                
                <!-- Product Info -->
                <div class="w-1/2">
                    <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
<p class="text-gray-600 mb-4">{{ $product->category }}</p>
<p class="text-2xl font-bold mb-6">{{ number_format($product->price) }}₫</p>
                    
                    <div class="mb-8">
                        <h3 class="font-bold mb-3">Chọn size</h3>
                        <p class="text-sm text-gray-600 mb-4">Giày chạy size lớn, khuyến nghị chọn size nhỏ hơn 1 size so với bình thường</p>
                        
                        <div class="grid grid-cols-3 gap-3 mb-4">
    @foreach(json_decode($product->available_sizes, true) as $size)
        <div class="size-option">{{ $size }}</div>
    @endforeach
</div>
                        
                        <button class="w-full bg-black text-white py-3 rounded-md hover:bg-gray-800 transition duration-200 font-medium mb-4">
                            Thêm vào giỏ hàng
                        </button>
                        
                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Miễn phí vận chuyển cho đơn hàng từ 500.000₫</span>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="font-bold mb-2">Hướng dẫn chọn size</h4>
                            <table class="size-guide-table text-sm">
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
                            <p class="text-xs text-gray-500 mt-2">* Lưu ý: Kích thước có thể thay đổi tùy thuộc vào kiểu dáng giày và thương hiệu</p>
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
                        <a href="#" class="text-sm font-medium underline">Xem chi tiết sản phẩm</a>
                    </div>
                </div>
            </div>
            
            <!-- Product Details Tabs -->
            <div class="border-t border-gray-200 mt-12 pt-8">
                <div class="flex gap-8 border-b border-gray-200">
                    <button class="tab-button pb-4 font-medium border-b-2 border-black" data-tab="size-fit">Size & Fit</button>
                    <button class="tab-button pb-4 font-medium text-gray-500" data-tab="shipping-return">Vận chuyển & Đổi trả</button>
                    <button class="tab-button pb-4 font-medium text-gray-500" data-tab="reviews">Đánh giá (5477)</button>
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
                                <li>Đổi trả miễn phí trong vòng 30 ngày nếu sản phẩm còn nguyên tag, hóa đơn và chưa qua sử dụng</li>
                                <li>Chỉ áp dụng đổi size/ màu (nếu còn hàng) hoặc hoàn tiền</li>
                                <li>Sản phẩm sale chỉ được đổi sang sản phẩm khác có giá trị tương đương hoặc cao hơn</li>
                                <li>Không áp dụng đổi trả với sản phẩm đã qua sử dụng hoặc bị hư hỏng do người dùng</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2">3. Liên hệ</h4>
                            <p>Mọi thắc mắc về đơn hàng vui lòng liên hệ hotline 1900 1234 hoặc email support@hike.vn</p>
                        </div>
                    </div>
                </div>

                <div id="reviews" class="tab-content py-6 hidden">
                    <div class="mb-8">
                        <h3 class="font-bold mb-4">Viết đánh giá của bạn</h3>
                        <form id="review-form" class="space-y-4">
                            <div class="rating">
                                <input type="radio" id="star5" name="rating" value="5" />
                                <label for="star5" title="5 sao">★</label>
                                <input type="radio" id="star4" name="rating" value="4" />
                                <label for="star4" title="4 sao">★</label>
                                <input type="radio" id="star3" name="rating" value="3" />
                                <label for="star3" title="3 sao">★</label>
                                <input type="radio" id="star2" name="rating" value="2" />
                                <label for="star2" title="2 sao">★</label>
                                <input type="radio" id="star1" name="rating" value="1" />
                                <label for="star1" title="1 sao">★</label>
                            </div>
                            <textarea name="comment" rows="4" class="w-full border border-gray-300 rounded-md p-2" placeholder="Chia sẻ cảm nhận của bạn về sản phẩm..."></textarea>
                            <button type="submit" class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 transition">Gửi đánh giá</button>
                        </form>
                    </div>

                    <div id="customer-reviews">
                        <h3 class="font-bold mb-4">Đánh giá từ khách hàng</h3>
                        <div class="space-y-6">
                            <!-- Sample reviews will be added by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Customer Images Section -->
            <div class="mt-16">
                <h2 class="text-2xl font-bold mb-6">Cách người khác phối đồ với giày này</h2>
                <div class="customer-images mb-8">
                    <img src="{{ asset('images/customer-5.jpg') }}" alt="Khách hàng diện Nike Air Force" loading="lazy">
                    <img src="{{ asset('images/customer-6.jpg') }}" alt="Khách hàng diện Nike Air Force" loading="lazy">
                    <img src="{{ asset('images/customer-7.jpg') }}" alt="Khách hàng diện Nike Air Force" loading="lazy">
                    <img src="{{ asset('images/customer-8.jpg') }}" alt="Khách hàng diện Nike Air Force" loading="lazy">
                </div>
            </div>
            
            <!-- Similar Products Section -->
            <div class="mt-16">
                <h2 class="text-2xl font-bold mb-6">Sản phẩm tương tự</h2>
                <div class="related-products">
    @foreach($relatedProducts as $related)
    <div class="product-card">
        <div class="bg-gray-100 rounded-lg overflow-hidden mb-3">
            @php
                $relatedMainImage = trim(explode(' ', $related->image)[0]);
            @endphp
            <img src="{{ asset('images/' . $relatedMainImage) }}" alt="{{ $related->name }}" class="w-full h-auto" loading="lazy">
        </div>
        <h4 class="font-medium">{{ $related->name }}</h4>
        <p class="text-sm text-gray-600">{{ $related->category }}</p>
        <p class="font-bold">{{ number_format($related->price) }}₫</p>
    </div>
    @endforeach
</div>
            </div>
        </div>
    </main>

    @include('layouts.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Size selection functionality
            const sizeOptions = document.querySelectorAll('.size-option');
            sizeOptions.forEach(option => {
                option.addEventListener('click', function() {
                    sizeOptions.forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
            
            // Tab switching functionality
            const tabs = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Update tab buttons
                    tabs.forEach(t => {
                        t.classList.remove('border-black', 'text-black');
                        t.classList.add('text-gray-500');
                    });
                    this.classList.add('border-black', 'text-black');
                    this.classList.remove('text-gray-500');
                    
                    // Show selected tab content
                    const tabId = this.getAttribute('data-tab');
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                        if (content.id === tabId) {
                            content.classList.remove('hidden');
                        }
                    });
                });
            });

            // Sample reviews data
            const sampleReviews = [
                {
                    name: "Nguyễn Văn A",
                    rating: 5,
                    date: "15/06/2023",
                    comment: "Giày đẹp, chất lượng tốt, đi êm chân. Size chuẩn như mô tả, mình đi size 40 vừa vặn. Giao hàng nhanh, đóng gói cẩn thận."
                },
                {
                    name: "Trần Thị B",
                    rating: 4,
                    date: "10/06/2023",
                    comment: "Giày đẹp, chất liệu da tốt nhưng hơi cứng lúc mới đi. Sau 2 ngày thì êm hơn. Nhân viên tư vấn nhiệt tình."
                },
                {
                    name: "Lê Văn C",
                    rating: 5,
                    date: "05/06/2023",
                    comment: "Rất hài lòng với sản phẩm! Giày thiết kế đẹp, form dáng chuẩn. Mình thường đi size 41 nhưng theo hướng dẫn chọn size 40 vừa vặn."
                }
            ];

            // Display sample reviews
            // Thay phần sample reviews bằng dynamic data nếu bạn có
const reviewsContainer = document.querySelector('#customer-reviews .space-y-6');
@if($product->reviews && count($product->reviews) > 0)
    @foreach($product->reviews as $review)
        const reviewElement = document.createElement('div');
        reviewElement.className = 'review';
        reviewElement.innerHTML = `
            <div class="flex items-center mb-2">
                <div class="font-semibold mr-2">{{ $review->user->name }}</div>
                <div class="text-yellow-400">
                    ${'★'.repeat({{ $review->rating }})}${'☆'.repeat(5 - {{ $review->rating }})}
                </div>
                <div class="text-gray-500 text-sm ml-2">{{ $review->created_at->format('d/m/Y') }}</div>
            </div>
            <p class="text-gray-700">{{ $review->comment }}</p>
        `;
        reviewsContainer.appendChild(reviewElement);
    @endforeach
@else
    // Hiển thị message nếu không có review
    const noReviewElement = document.createElement('div');
    noReviewElement.className = 'text-gray-500 italic';
    noReviewElement.textContent = 'Chưa có đánh giá nào cho sản phẩm này';
    reviewsContainer.appendChild(noReviewElement);
@endif

            // Sample similar products data (would normally come from database)
            const similarProducts = [
                {
                    id: 1,
                    name: "Nike Air Force 1 LVB",
                    category: "Giày thể thao nam",
                    price: "2.699.000₫",
                    image: "related-1.jpg"
                },
                {
                    id: 2,
                    name: "Nike Dunk Low Retro",
                    category: "Giày thể thao nam",
                    price: "2.799.000₫",
                    image: "related-2.jpg"
                },
                {
                    id: 3,
                    name: "Nike Air Force 1 EasyOn",
                    category: "Giày thể thao nữ",
                    price: "2.599.000₫",
                    image: "related-3.jpg"
                },
                {
                    id: 4,
                    name: "Nike Air Max 90",
                    category: "Giày thể thao nam",
                    price: "3.299.000₫",
                    image: "related-4.jpg"
                }
            ];

            // Display similar products
            const productsContainer = document.querySelector('.related-products');
            similarProducts.forEach(product => {
                const productElement = document.createElement('div');
                productElement.className = 'product-card';
                productElement.innerHTML = `
                    <div class="bg-gray-100 rounded-lg overflow-hidden mb-3">
                        <img src="{{ asset('images/${product.image}') }}" alt="${product.name}" class="w-full h-auto" loading="lazy">
                    </div>
                    <h4 class="font-medium">${product.name}</h4>
                    <p class="text-sm text-gray-600">${product.category}</p>
                    <p class="font-bold">${product.price}</p>
                `;
                productsContainer.appendChild(productElement);
            });

            // Review form submission
            const reviewForm = document.getElementById('review-form');
            reviewForm.addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Cảm ơn bạn đã đánh giá sản phẩm!');
                reviewForm.reset();
            });
        });
    </script>
</body>
</html>