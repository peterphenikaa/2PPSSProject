<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa đơn hàng #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</title>
    @vite(['resources/css/app.css', 'resources/css/createproduct.css', 'resources/css/dashboard.css'])
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
</head>

<body class="bg-gray-50" style="font-family: 'Rubik', sans-serif;">
    <x-sidebar />
    <div class="main-content">
        <header class="mb-6">
            <div class="flex items-center text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <span class="mx-2">/</span>
                <a href="{{ route('admin.order') }}" class="hover:text-indigo-600">Đơn hàng</a>
                <span class="mx-2">/</span>
                <span class="text-indigo-600">Sửa đơn hàng #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Sửa thông tin đơn hàng</h1>
                 <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-secondary">
                    <span class="material-icons-round">arrow_back</span>
                    Quay về chi tiết
                </a>
            </div>
        </header>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Có lỗi xảy ra!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-section">
                 <h2 class="section-title"><span class="section-icon material-icons-round">badge</span>Thông tin giao hàng</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="recipient_name" class="form-label">Tên người nhận</label>
                        <input type="text" id="recipient_name" name="recipient_name" class="form-input"
                            value="{{ old('recipient_name', $order->recipient_name) }}">
                    </div>
                    <div>
                        <label for="recipient_phone" class="form-label">Số điện thoại</label>
                        <input type="text" id="recipient_phone" name="recipient_phone" class="form-input"
                            value="{{ old('recipient_phone', $order->recipient_phone) }}">
                    </div>
                     <div class="md:col-span-2">
                        <label for="address_detail" class="form-label">Địa chỉ chi tiết</label>
                        <input type="text" id="address_detail" name="address_detail" class="form-input"
                            value="{{ old('address_detail', $order->address_detail) }}">
                    </div>

                    <div>
                        <label for="province" class="form-label">Tỉnh/Thành phố</label>
                        <select id="province" name="province" class="form-input">
                            <option value="">Chọn Tỉnh/Thành phố</option>
                        </select>
                    </div>
                    <div>
                        <label for="district" class="form-label">Quận/Huyện</label>
                        <select id="district" name="district" class="form-input">
                            <option value="">Chọn Quận/Huyện</option>
                        </select>
                    </div>
                    <div>
                        <label for="ward" class="form-label">Phường/Xã</label>
                        <select id="ward" name="ward" class="form-input">
                            <option value="">Chọn Phường/Xã</option>
                        </select>
                    </div>
                </div>
                 <div class="flex justify-end mt-6">
                    <button type="submit" class="btn-primary">
                        <span class="material-icons-round">save</span>
                        Lưu thay đổi
                    </button>
                </div>
            </div>
        </form>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const host = "https://provinces.open-api.vn/api/";
            const provinceSelect = document.getElementById('province');
            const districtSelect = document.getElementById('district');
            const wardSelect = document.getElementById('ward');

            const currentProvince = "{{ old('province', $order->province) }}";
            const currentDistrict = "{{ old('district', $order->district) }}";
            const currentWard = "{{ old('ward', $order->ward) }}";

            function renderOptions(selectElement, data, selectedValue) {
                let options = '<option value="">' + selectElement.options[0].text + '</option>';
                data.forEach(item => {
                    const isSelected = item.code == selectedValue ? 'selected' : '';
                    options += `<option value="${item.code}" ${isSelected}>${item.name}</option>`;
                });
                selectElement.innerHTML = options;
            }

            async function fetchAndRenderProvinces() {
                const response = await fetch(host + '?depth=1');
                const provinces = await response.json();
                renderOptions(provinceSelect, provinces, currentProvince);
                if (currentProvince) {
                    provinceSelect.dispatchEvent(new Event('change'));
                }
            }

            async function fetchAndRenderDistricts() {
                const provinceCode = provinceSelect.value;
                 if (!provinceCode) {
                    districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
                    wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
                    return;
                 }
                const response = await fetch(`${host}p/${provinceCode}?depth=2`);
                const data = await response.json();
                renderOptions(districtSelect, data.districts, currentDistrict);
                if (currentDistrict) {
                    districtSelect.dispatchEvent(new Event('change'));
                }
            }

            async function fetchAndRenderWards() {
                const districtCode = districtSelect.value;
                if (!districtCode) {
                    wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
                    return;
                }
                const response = await fetch(`${host}d/${districtCode}?depth=2`);
                const data = await response.json();
                renderOptions(wardSelect, data.wards, currentWard);
            }
            
            provinceSelect.addEventListener('change', fetchAndRenderDistricts);
            districtSelect.addEventListener('change', fetchAndRenderWards);

            fetchAndRenderProvinces();
        });
    </script>
</body>

</html> 