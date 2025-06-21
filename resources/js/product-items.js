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
    const orderForm = document.getElementById('order-form');
    let selectedSize = null;

    if (orderForm) {
        orderForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submit-btn');
            const loading = submitBtn.querySelector('.loading');
            
            submitBtn.disabled = true;
            loading.classList.remove('hidden');
            
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
                    document.getElementById('order-popup').classList.remove('active');
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
    }

    sizeOptions.forEach(option => {
        option.addEventListener('click', () => {
            sizeOptions.forEach(o => o.classList.remove('bg-black', 'text-white'));
            option.classList.add('bg-black', 'text-white');
            selectedSize = option.dataset.size;
            if (selectedSizeInput) {
                selectedSizeInput.value = selectedSize;
            }
        });
    });

    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', () => {
            if (!isLoggedIn) {
                alert("Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng");
                window.location.href = '/login';
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

            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert(data.success);
                    // Optionally, update cart count in the UI
                    const cartCountElement = document.querySelector('.cart-count'); // Assuming you have an element with this class
                    if (cartCountElement && data.cart_count) {
                        cartCountElement.textContent = data.cart_count;
                    }
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
});

function showOrderPopup() {
    const popup = document.getElementById('order-popup');
    popup.classList.remove('hidden');
}

