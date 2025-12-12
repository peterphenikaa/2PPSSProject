# 🚀 QUICK START - Docker Setup

## Cách chạy nhanh nhất:

### Windows:

```bash
docker-setup.bat
```

### Linux/Mac:

```bash
chmod +x docker-setup.sh
./docker-setup.sh
```

## Hoặc chạy thủ công:

```bash
# 1. Copy env file
cp .env.docker .env

# 2. Start Docker
docker-compose up -d --build

# 3. Install dependencies
docker-compose exec app composer install

# 4. Generate key
docker-compose exec app php artisan key:generate

# 5. Migrate database
docker-compose exec app php artisan migrate --seed

# 6. Fix permissions
docker-compose exec app chmod -R 777 storage bootstrap/cache
```

## 🌐 Truy cập:

-   **Website**: http://localhost:8080
-   **phpMyAdmin**: http://localhost:8081 (root/root_password)
-   **MinIO Console**: http://localhost:9001 (minioadmin/minioadmin123)

## 📸 Migrate ảnh cũ lên MinIO:

```bash
# Preview (không thực hiện)
docker-compose exec app php artisan storage:migrate-to-minio --dry-run

# Migrate tất cả
docker-compose exec app php artisan storage:migrate-to-minio

# Chỉ migrate products
docker-compose exec app php artisan storage:migrate-to-minio --model=products

# Chỉ migrate blogs
docker-compose exec app php artisan storage:migrate-to-minio --model=blogs
```

## 🛠️ Sử dụng ImageService trong Controller:

```php
use App\Services\ImageService;

// Upload single image
$url = ImageService::upload($request->file('image'), 'products');
$product->image = $url;

// Upload multiple images
$urls = ImageService::uploadMultiple($request->file('images'), 'products');
$product->additional_images = $urls;

// Delete image
ImageService::delete($product->image);

// Delete multiple
ImageService::deleteMultiple($product->additional_images);
```

## 🔍 Trong Blade View:

```blade
{{-- Hiển thị ảnh từ MinIO --}}
<img src="{{ $product->image }}" alt="{{ $product->name }}">

{{-- Multiple images --}}
@foreach($product->additional_images as $image)
    <img src="{{ $image }}" alt="">
@endforeach
```

## 🛑 Stop và cleanup:

```bash
# Stop services
docker-compose down

# Stop và xóa volumes (CẢNH BÁO: Mất data!)
docker-compose down -v
```

## 📝 Xem logs:

```bash
# All services
docker-compose logs -f

# Specific service
docker-compose logs -f app
docker-compose logs -f mysql
docker-compose logs -f minio
```

---

Chi tiết đầy đủ xem file: **DOCKER-README.md**
