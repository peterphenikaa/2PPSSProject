<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        /* Custom CSS */
        .filter-section {
            transition: all 0.3s ease;
        }
        
        .filter-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .filter-section.active .filter-content {
            max-height: 500px;
        }
        
        .filter-toggle svg {
            transition: transform 0.3s ease;
        }
        
        .filter-section.active .filter-toggle svg {
            transform: rotate(180deg);
        }
        
        .price-slider {
            -webkit-appearance: none;
            width: 100%;
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
            outline: none;
        }
        
        .price-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 16px;
            height: 16px;
            background: #000;
            border-radius: 50%;
            cursor: pointer;
        }
        
        .product-card {
            transition: all 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
        }
        
        .product-image-container {
            aspect-ratio: 1/1;
        }
        
        .empty-state {
            min-height: 400px;
        }
        
        /* Size grid styles */
        .size-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }
        
        .size-option {
            border: 1px solid #e5e7eb;
            text-align: center;
            padding: 6px 0;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .size-option:hover {
            border-color: #000;
        }
        
        .size-option.selected {
            background-color: #000;
            color: white;
            border-color: #000;
        }
        
        .size-checkbox {
            display: none;
        }
    </style>
</head>
<body>

    @include('layouts.header')

    <main>
        <div class="bg-white px-6 py-10">
            <div class="flex gap-8">
                <!-- SIDEBAR FILTER -->
                <form method="GET" action="{{ route('products.filter', $filter ?? 'sneakers') }}" class="w-1/5 space-y-6 text-sm font-medium">
                    @foreach ([
                        ['label' => 'Tên sản phẩm', 'data' => $names, 'name' => 'name'],
                        ['label' => 'Giới tính', 'data' => $genders, 'name' => 'gender'],
                        ['label' => 'Colorway', 'data' => $colorways, 'name' => 'colorway']
                    ] as $section)
                        <div class="filter-section border-b border-gray-200 pb-4">
                            <button type="button" class="filter-toggle w-full flex justify-between items-center py-2 focus:outline-none">
                                <span class="text-black font-semibold text-base">{{ $section['label'] }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="filter-content mt-2 pl-1">
                                <div class="space-y-2">
                                    @foreach($section['data'] as $item)
                                        <label class="flex items-center gap-3 cursor-pointer text-gray-700 hover:text-black py-1">
                                            <input 
                                                type="checkbox" 
                                                name="{{ $section['name'] }}[]" 
                                                value="{{ $item }}" 
                                                class="w-4 h-4 accent-black rounded border-gray-300 focus:ring-black"
                                                {{ collect(request($section['name']))->contains($item) ? 'checked' : '' }}
                                            >
                                            <span class="capitalize text-sm">{{ is_array($item) ? implode(',', $item) : $item }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Size Filter -->
                    <div class="filter-section border-b border-gray-200 pb-4">
                        <button type="button" class="filter-toggle w-full flex justify-between items-center py-2 focus:outline-none">
                            <span class="text-black font-semibold text-base">Kích cỡ</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="filter-content mt-2">
                            <div class="size-grid">
                                @php
                                    // Assuming $sizes is an array of available sizes passed from controller
                                    $availableSizes = $sizes ?? range(35, 45); // Default sizes if not provided
                                    $selectedSizes = request('size', []);
                                @endphp
                                
                                @foreach($availableSizes as $size)
                                    <label class="size-option {{ in_array($size, $selectedSizes) ? 'selected' : '' }}">
                                        <input 
                                            type="checkbox" 
                                            name="size[]" 
                                            value="{{ $size }}" 
                                            class="size-checkbox"
                                            {{ in_array($size, $selectedSizes) ? 'checked' : '' }}
                                        >
                                        {{ $size }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div class="border-b border-gray-200 pb-4">
                        <label class="font-bold block mb-2 text-base">Giá tối đa</label>
                        <input 
                            type="range" 
                            name="price" 
                            min="50000" 
                            max="5000000" 
                            step="50000" 
                            value="{{ request('price', 5000000) }}"
                            oninput="this.nextElementSibling.innerText = parseInt(this.value).toLocaleString() + ' ₫'" 
                            class="price-slider"
                        >
                        <span class="text-sm text-gray-700 block mt-2">
                            {{ number_format(request('price', 5000000), 0, ',', '.') }} ₫
                        </span>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full bg-black text-white py-3 rounded-md hover:bg-gray-800 transition duration-200 font-medium"
                    >
                        Áp dụng bộ lọc
                    </button>
                </form>

                <!-- PRODUCT LIST -->
                <div class="w-4/5">
                    <div class="grid grid-cols-3 gap-6">
                        @forelse ($products as $product)
                            <a href="{{ url('/product/' . $product->id) }}" class="block">
    <div class="product-card group border border-gray-100 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-300 bg-white hover:border-gray-200">
        <div class="w-full product-image-container bg-gray-50 overflow-hidden">
            <img 
                src="{{ asset('images/' . $product->image) }}"
                alt="{{ $product->name }}"
                class="w-full h-full object-contain p-4 transition-transform duration-300 group-hover:scale-105"
                loading="lazy"
            >
        </div>
        <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-1 truncate">{{ $product->name }}</h3>
            <p class="text-xs text-gray-500 mb-2">{{ $product->category }} • {{ $product->gender }}</p>
            <p class="text-lg font-bold text-gray-900">{{ number_format($product->price, 0, ',', '.') }} ₫</p>
        </div>
    </div>
</a>

                        @empty
                            <div class="col-span-3 empty-state flex flex-col items-center justify-center py-12 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-4 text-lg font-medium text-gray-700">Không tìm thấy sản phẩm nào</h3>
                                <p class="mt-1 text-sm text-gray-500">Hãy thử điều chỉnh bộ lọc của bạn</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterToggles = document.querySelectorAll('.filter-toggle');
            
            filterToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const section = this.closest('.filter-section');
                    section.classList.toggle('active');
                });
            });
            
            document.querySelectorAll('.filter-section').forEach(section => {
                const hasChecked = section.querySelector('input[type="checkbox"]:checked');
                if (hasChecked) {
                    section.classList.add('active');
                }
            });
            
            const priceSlider = document.querySelector('input[type="range"]');
            if (priceSlider) {
                priceSlider.addEventListener('input', function() {
                    const value = (this.value - this.min) / (this.max - this.min) * 100;
                    this.style.background = `linear-gradient(to right, #000 0%, #000 ${value}%, #e5e7eb ${value}%, #e5e7eb 100%)`;
                });
            
                priceSlider.dispatchEvent(new Event('input'));
            }
            
            document.querySelectorAll('.size-option').forEach(option => {
                option.addEventListener('click', function() {
                    const checkbox = this.querySelector('input[type="checkbox"]');
                    checkbox.checked = !checkbox.checked;
                    this.classList.toggle('selected', checkbox.checked);
                });
            });
        });
    </script>
</body>
</html>