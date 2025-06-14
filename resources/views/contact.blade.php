@extends('layouts.layouts')

@section('content')
<div class="container mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold mb-6 text-center">Tìm cửa hàng/đại lý gần bạn</h1>
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar: Danh sách cửa hàng -->
        <div class="w-full md:w-1/3 bg-white rounded-lg shadow p-4 h-[600px] overflow-y-auto">
            <div class="mb-4">
                <input type="text" id="search-store" placeholder="Tìm kiếm địa điểm, tên cửa hàng..." class="w-full border rounded p-2" oninput="filterStores()">
            </div>
            <div id="store-list">
                @foreach($stores as $store)
                <div class="mb-4 p-3 border-b cursor-pointer hover:bg-gray-50" onclick="focusStore({{ $store->id }})">
                    <div class="font-semibold text-lg">{{ $store->name }}</div>
                    <div class="text-gray-600 text-sm">{{ $store->address }}</div>
                    <div class="text-gray-500 text-xs">{{ $store->city }}, {{ $store->province }}</div>
                    <div class="text-green-600 text-xs font-medium mt-1">{{ $store->status === 'open' ? 'Open' : 'Closed' }}{{ $store->opening_hours ? ' - ' . $store->opening_hours : '' }}</div>
                    <div class="text-xs mt-1">{{ $store->phone }}</div>
                </div>
                @endforeach
            </div>
        </div>
        <!-- Bản đồ -->
        <div class="w-full md:w-2/3 h-[600px] rounded-lg overflow-hidden shadow" id="map"></div>
    </div>
</div>
<!-- LeafletJS CDN -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Dữ liệu cửa hàng từ backend
    const stores = @json($stores);
    let map, markers = [];
    document.addEventListener('DOMContentLoaded', function () {
        // Khởi tạo bản đồ
        map = L.map('map').setView([21.028511, 105.804817], 6); // Mặc định Hà Nội
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        // Thêm marker cho từng cửa hàng
        stores.forEach(store => {
            if (store.latitude && store.longitude) {
                const marker = L.marker([store.latitude, store.longitude]).addTo(map)
                    .bindPopup(`<b>${store.name}</b><br>${store.address}<br>${store.city}, ${store.province}<br>${store.phone ? 'Phone: ' + store.phone : ''}`);
                marker.storeId = store.id;
                markers.push(marker);
            }
        });
    });
    // Focus vào marker khi click danh sách
    function focusStore(id) {
        const store = stores.find(s => s.id === id);
        if (store && store.latitude && store.longitude) {
            map.setView([store.latitude, store.longitude], 15);
            const marker = markers.find(m => m.storeId === id);
            if (marker) marker.openPopup();
        }
    }
    // Lọc danh sách cửa hàng
    function filterStores() {
        const keyword = document.getElementById('search-store').value.toLowerCase();
        const list = document.getElementById('store-list');
        let html = '';
        stores.forEach(store => {
            if (
                store.name.toLowerCase().includes(keyword) ||
                (store.address && store.address.toLowerCase().includes(keyword)) ||
                (store.city && store.city.toLowerCase().includes(keyword)) ||
                (store.province && store.province.toLowerCase().includes(keyword))
            ) {
                html += `<div class='mb-4 p-3 border-b cursor-pointer hover:bg-gray-50' onclick='focusStore(${store.id})'>
                    <div class='font-semibold text-lg'>${store.name}</div>
                    <div class='text-gray-600 text-sm'>${store.address}</div>
                    <div class='text-gray-500 text-xs'>${store.city ?? ''}, ${store.province ?? ''}</div>
                    <div class='text-green-600 text-xs font-medium mt-1'>${store.status === 'open' ? 'Open' : 'Closed'}${store.opening_hours ? ' - ' + store.opening_hours : ''}</div>
                    <div class='text-xs mt-1'>${store.phone ?? ''}</div>
                </div>`;
            }
        });
        list.innerHTML = html;
    }
</script>
@endsection

@section('meta_title', 'Liên hệ - 2PSS Sneaker')
@section('meta_description', 'Thông tin liên hệ, đại lý, cửa hàng 2PSS Sneaker trên toàn quốc.')
@section('meta_image', asset('images/anh_main.jpg')) 