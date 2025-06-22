@extends('layouts.layouts')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-8 px-2">
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl p-8 md:p-12 mx-auto">
        <h2 class="text-3xl md:text-4xl font-extrabold mb-8 text-center tracking-tight text-gray-900">Thanh toán đơn hàng</h2>
        <div class="mb-8">
            <h3 class="text-lg font-semibold mb-3 text-gray-800">Sản phẩm trong giỏ</h3>
            <div class="overflow-x-auto rounded-lg border border-gray-200 bg-gray-50">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 font-semibold text-left">Ảnh</th>
                            <th class="p-3 font-semibold text-left">Tên</th>
                            <th class="p-3 font-semibold text-center">Size</th>
                            <th class="p-3 font-semibold text-center">SL</th>
                            <th class="p-3 font-semibold text-right">Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($cart as $item)
                            @php $total += $item['price'] * $item['quantity']; @endphp
                            <tr class="border-t border-gray-200">
                                <td class="p-3">
                                    @if($item['image'])
                                        <img src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-14 h-14 object-cover rounded-lg border">
                                    @else
                                        <span class="text-gray-400">Không có ảnh</span>
                                    @endif
                                </td>
                                <td class="p-3 font-medium text-gray-900">{{ $item['name'] }}</td>
                                <td class="p-3 text-center">{{ $item['size'] }}</td>
                                <td class="p-3 text-center">{{ $item['quantity'] }}</td>
                                <td class="p-3 text-right font-semibold text-green-700">{{ number_format($item['price'] * $item['quantity']) }}₫</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-right font-bold text-lg mt-2 pr-3">Tổng cộng: <span class="text-green-600">{{ number_format($total) }}₫</span></div>
            </div>
        </div>
        <form action="{{ route('cart.checkout.submit') }}" method="POST" class="space-y-5" id="checkout-form">
            @csrf
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <input type="hidden" name="province_name" id="province_name">
            <input type="hidden" name="district_name" id="district_name">
            <input type="hidden" name="ward_name" id="ward_name">
            <div>
                <label for="recipient_name" class="block font-semibold mb-1 text-gray-800">Họ tên người nhận</label>
                <input type="text" id="recipient_name" name="recipient_name" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" required>
            </div>
            <div>
                <label for="recipient_phone" class="block font-semibold mb-1 text-gray-800">Số điện thoại</label>
                <input type="text" id="recipient_phone" name="recipient_phone" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" required>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="province" class="block font-semibold mb-1 text-gray-800">Tỉnh/Thành phố</label>
                    <select id="province" name="province" class="w-full border border-gray-300 rounded-lg p-3" required>
                        <option value="">Chọn tỉnh/thành phố</option>
                    </select>
                </div>
                <div>
                    <label for="district" class="block font-semibold mb-1 text-gray-800">Quận/Huyện</label>
                    <select id="district" name="district" class="w-full border border-gray-300 rounded-lg p-3" required disabled>
                        <option value="">Chọn quận/huyện</option>
                    </select>
                </div>
                <div>
                    <label for="ward" class="block font-semibold mb-1 text-gray-800">Phường/Xã</label>
                    <select id="ward" name="ward" class="w-full border border-gray-300 rounded-lg p-3" required disabled>
                        <option value="">Chọn phường/xã</option>
                    </select>
                </div>
            </div>
            <div>
                <label for="address_detail" class="block font-semibold mb-1 text-gray-800">Địa chỉ chi tiết</label>
                <input type="text" id="address_detail" name="address_detail" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" required>
            </div>
            <div>
                <label for="payment_method" class="block font-semibold mb-1 text-gray-800">Phương thức thanh toán</label>
                <select id="payment_method" name="payment_method" class="w-full border border-gray-300 rounded-lg p-3">
                    <option value="cod">Thanh toán khi nhận hàng</option>
                    <option value="momo_qr">Thanh toán Momo/VietQR (quét mã QR)</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-xl font-bold text-lg shadow-lg hover:bg-green-700 transition">Xác nhận mua hàng</button>
        </form>
    </div>
</div>
<script>
function loadProvinces() {
    fetch('https://provinces.open-api.vn/api/')
        .then(response => response.json())
        .then(provinces => {
            const provinceSelect = document.getElementById('province');
            provinceSelect.innerHTML = '<option value="">Chọn tỉnh/thành phố</option>';
            provinces.forEach(province => {
                const option = document.createElement('option');
                option.value = province.code;
                option.textContent = province.name;
                provinceSelect.appendChild(option);
            });
            // Nếu có old value thì set lại
            @if (old('province'))
                for (let i = 0; i < provinceSelect.options.length; i++) {
                    if (provinceSelect.options[i].value == "{{ old('province') }}") {
                        provinceSelect.selectedIndex = i;
                        break;
                    }
                }
                if (provinceSelect.value) {
                    loadDistricts(provinceSelect.value);
                }
            @endif
        });
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
            districtSelect.disabled = false;
            document.getElementById('ward').disabled = true;
            document.getElementById('ward').innerHTML = '<option value="">Chọn phường/xã</option>';
            // Nếu có old value thì set lại
            @if (old('district'))
                for (let i = 0; i < districtSelect.options.length; i++) {
                    if (districtSelect.options[i].value == "{{ old('district') }}") {
                        districtSelect.selectedIndex = i;
                        break;
                    }
                }
                if (districtSelect.value) {
                    loadWards(districtSelect.value);
                }
            @endif
        });
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
            // Nếu có old value thì set lại
            @if (old('ward'))
                for (let i = 0; i < wardSelect.options.length; i++) {
                    if (wardSelect.options[i].value == "{{ old('ward') }}") {
                        wardSelect.selectedIndex = i;
                        break;
                    }
                }
            @endif
        });
}
document.addEventListener('DOMContentLoaded', function () {
    loadProvinces();
    document.getElementById('province').addEventListener('change', function() {
        const provinceId = this.value;
        if (provinceId) {
            loadDistricts(provinceId);
        } else {
            const districtSelect = document.getElementById('district');
            districtSelect.disabled = true;
            districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
            const wardSelect = document.getElementById('ward');
            wardSelect.disabled = true;
            wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
        }
    });
    document.getElementById('district').addEventListener('change', function() {
        const districtId = this.value;
        if (districtId) {
            loadWards(districtId);
        } else {
            const wardSelect = document.getElementById('ward');
            wardSelect.disabled = true;
            wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
        }
    });
});
</script>
@endsection 