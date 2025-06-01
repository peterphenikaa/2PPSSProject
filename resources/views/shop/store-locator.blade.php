@extends('main')

@section('title', 'Find 2P Sneaker Store')

@section('content')
<style>
    .store-locator-wrapper {
        display: flex;
        flex-direction: row;
        align-items: stretch;
        height: 600px; /* Cố định chiều cao */
        max-width: 100vw;
        overflow: hidden;
    }

    .sidebar {
        width: 400px;
        padding: 20px;
        overflow-y: auto;
        border-right: 1px solid #ccc;
    }

    .map-container {
        flex-grow: 1;
        height: 100%;
    }

    #map {
        width: 100%;
        height: 100%;
        min-height: 100%;
    }
</style>

<div class="store-locator-wrapper">
    <div class="sidebar">
        <h3 style="margin-top: 0;">Tìm cửa hàng 2P Sneaker</h3>
        <input type="text" id="search" placeholder="Tìm địa điểm..." style="width:100%; padding:8px; margin-bottom:10px; border:1px solid #ccc; border-radius:4px;">
        <div id="location-list">
            @foreach($locations as $loc)
                <div class="location-item" data-lat="{{ $loc->latitude }}" data-lng="{{ $loc->longitude }}"
                     style="cursor:pointer; padding:10px; border-bottom:1px solid #eee;">
                    <strong>{{ $loc->name }}</strong><br>
                    <small>{{ $loc->address }}</small>
                </div>
            @endforeach
        </div>
    </div>

    <div class="map-container">
        <div id="map"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const map = L.map('map').setView([
        {{ $locations[0]->latitude ?? 20.9626 }},
        {{ $locations[0]->longitude ?? 105.7461 }}
    ], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Bắt buộc để map hiển thị đúng nếu bị lệch
    setTimeout(() => {
        map.invalidateSize();
    }, 300);

    @foreach($locations as $loc)
        const marker = L.marker([{{ $loc->latitude }}, {{ $loc->longitude }}])
            .addTo(map)
            .bindPopup(<b>{{ $loc->name }}</b><br>{{ $loc->address }});
    @endforeach

    document.querySelectorAll('.location-item').forEach(item => {
        item.addEventListener('click', () => {
            const lat = item.getAttribute('data-lat');
            const lng = item.getAttribute('data-lng');
            map.setView([lat, lng], 16);
        });
    });

    document.getElementById('search').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('.location-item').forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(keyword) ? 'block' : 'none';
        });
    });
</script>
@endsection