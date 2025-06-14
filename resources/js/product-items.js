function route(name, parameters = {}) {
    let url = '/';
    
    // Định nghĩa các route (có thể thay bằng cách tốt hơn nếu dùng Laravel)
    const routes = {
        'register': '/register',
        // Thêm các route khác nếu cần
    };
    
    if (routes[name]) {
        url = routes[name];
        
        // Thay thế các tham số trong URL
        for (const [key, value] of Object.entries(parameters)) {
            url = url.replace(`{${key}}`, value);
        }
    }
    
    return url;
}

document.addEventListener("DOMContentLoaded", function () {
    const sizeOptions = document.querySelectorAll('.size-option');
    const selectedSizeInput = document.getElementById('selected_size');
    const addToCartBtn = document.querySelector('.add-to-cart-btn');
   document.getElementById('order-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submit-btn');
    const loading = submitBtn.querySelector('.loading');
    
    submitBtn.disabled = true;
    loading.classList.remove('hidden');
    
    // Thêm đoạn code này để kiểm tra lỗi
    fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Đặt hàng thành công!');
            orderPopup.classList.remove('active');
        } else {
            alert('Có lỗi xảy ra: ' + (data.message || 'Vui lòng thử lại'));
        }
    })
    .catch(error => {
        alert('Lỗi kết nối: ' + error.message);
    })
    .finally(() => {
        submitBtn.disabled = false;
        loading.classList.add('hidden');
    });
});

    sizeOptions.forEach(option => {
        option.addEventListener('click', () => {
            sizeOptions.forEach(o => o.classList.remove('bg-black', 'text-white'));
            option.classList.add('bg-black', 'text-white');
            selectedSizeInput.value = option.dataset.size;
        });
    });

    addToCartBtn.addEventListener('click', () => {
        if (!isLoggedIn) {
            alert("Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng");
            return;
        }
        
        if (!selectedSizeInput.value) {
            alert("Vui lòng chọn size trước khi mua hàng.");
            return;
        }
        
        // Hiển thị popup thay vì scroll
        showOrderPopup();
    });
});

function showOrderPopup() {
    const popup = document.getElementById('order-popup');
    popup.classList.remove('hidden');
}

