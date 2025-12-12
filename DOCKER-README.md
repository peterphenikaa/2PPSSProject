# 🐳 Docker Setup cho 2PSS Sneaker

## 📋 Tổng quan

Dự án sử dụng Docker với các services:

-   **Laravel App** (PHP 8.2-FPM)
-   **Nginx** (Web Server)
-   **MySQL 8.0** (Database)
-   **phpMyAdmin** (Quản lý Database)
-   **MinIO** (Object Storage - thay thế lưu ảnh trong assets)
-   **Node.js** (Vite dev server)

## 🚀 Cài đặt và Chạy

### Bước 1: Chuẩn bị

```bash
# Copy file env mẫu
cp .env.docker .env

# Hoặc cập nhật .env hiện tại với config MinIO
```

### Bước 2: Build và khởi động containers

```bash
# Build và start tất cả services
docker-compose up -d --build

# Hoặc chỉ start (nếu đã build)
docker-compose up -d
```

### Bước 3: Cài đặt Laravel

```bash
# Vào container Laravel
docker-compose exec app bash

# Generate key
php artisan key:generate

# Chạy migration
php artisan migrate --seed

# Thoát container
exit
```

## 🌐 Truy cập các Services

| Service           | URL                   | Thông tin đăng nhập                         |
| ----------------- | --------------------- | ------------------------------------------- |
| **Website**       | http://localhost:8080 | -                                           |
| **phpMyAdmin**    | http://localhost:8081 | User: `root`<br>Pass: `root_password`       |
| **MinIO Console** | http://localhost:9001 | User: `minioadmin`<br>Pass: `minioadmin123` |
| **MinIO API**     | http://localhost:9000 | -                                           |

## 📦 Cấu hình MinIO

MinIO được cấu hình tự động tạo bucket `laravel-images` với quyền public download.

### Thông tin kết nối:

-   **Endpoint**: http://minio:9000 (trong container) hoặc http://localhost:9000 (từ host)
-   **Access Key**: minioadmin
-   **Secret Key**: minioadmin123
-   **Bucket**: laravel-images

### Upload ảnh từ Laravel:

```php
use Illuminate\Support\Facades\Storage;

// Upload file
$path = Storage::disk('minio')->put('products', $request->file('image'));

// Get URL
$url = Storage::disk('minio')->url($path);

// Delete file
Storage::disk('minio')->delete($path);
```

## 🔧 Các lệnh hữu ích

### Docker Compose

```bash
# Xem logs
docker-compose logs -f

# Logs của service cụ thể
docker-compose logs -f app
docker-compose logs -f mysql

# Stop tất cả services
docker-compose down

# Stop và xóa volumes (CẢNH BÁO: Mất dữ liệu!)
docker-compose down -v

# Restart service
docker-compose restart app

# Rebuild một service
docker-compose up -d --build app
```

### Laravel Commands

```bash
# Vào container app
docker-compose exec app bash

# Chạy migration
docker-compose exec app php artisan migrate

# Seed database
docker-compose exec app php artisan db:seed

# Clear cache
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear

# Queue worker
docker-compose exec app php artisan queue:work
```

### MySQL Commands

```bash
# Vào MySQL CLI
docker-compose exec mysql mysql -u laravel_user -plaravel_pass laravel_db

# Backup database
docker-compose exec mysql mysqldump -u root -proot_password laravel_db > backup.sql

# Restore database
docker-compose exec -T mysql mysql -u root -proot_password laravel_db < backup.sql
```

### MinIO Commands

```bash
# Vào MinIO Client
docker-compose exec minio-client mc alias list

# List buckets
docker-compose exec minio-client mc ls myminio

# List files trong bucket
docker-compose exec minio-client mc ls myminio/laravel-images

# Copy file vào MinIO
docker-compose exec minio-client mc cp /path/to/file myminio/laravel-images/
```

## 📁 Cấu trúc thư mục Docker

```
.
├── docker/
│   ├── nginx/
│   │   └── default.conf          # Nginx config
│   └── php/
│       └── local.ini              # PHP config
├── Dockerfile                     # Laravel app image
├── docker-compose.yml             # Services definition
├── .dockerignore                  # Files bỏ qua khi build
└── .env.docker                    # Env mẫu cho Docker
```

## ⚙️ Database Config

### MySQL

-   **Host**: mysql (trong container) hoặc localhost:3306 (từ host)
-   **Database**: laravel_db
-   **User**: laravel_user
-   **Password**: laravel_pass
-   **Root Password**: root_password

## 🔄 Migration từ Local Storage sang MinIO

### 1. Update Controller để dùng MinIO

```php
// Cũ (lưu trong public/images)
$image = $request->file('image');
$imageName = time() . '.' . $image->extension();
$image->move(public_path('images'), $imageName);
$product->image = $imageName;

// Mới (lưu trong MinIO)
$path = Storage::disk('minio')->put('products', $request->file('image'));
$product->image = $path; // Lưu đường dẫn đầy đủ
// Hoặc lưu URL: Storage::disk('minio')->url($path)
```

### 2. Hiển thị ảnh trong Blade

```blade
{{-- Cũ --}}
<img src="{{ asset('images/' . $product->image) }}">

{{-- Mới --}}
<img src="{{ Storage::disk('minio')->url($product->image) }}">

{{-- Hoặc nếu đã lưu full URL --}}
<img src="{{ $product->image }}">
```

### 3. Di chuyển ảnh cũ sang MinIO

```bash
# Vào container
docker-compose exec app bash

# Chạy script migrate (tạo artisan command)
php artisan storage:migrate-to-minio
```

## 🛠️ Troubleshooting

### Port đã được sử dụng

Nếu port 8080, 3306, 9000, 9001 đã bị chiếm, sửa trong `docker-compose.yml`:

```yaml
ports:
    - "8080:80" # Đổi thành "8090:80"
```

### Permission denied

```bash
# Fix quyền storage
docker-compose exec app chmod -R 777 storage bootstrap/cache
```

### MinIO không kết nối được

```bash
# Restart MinIO
docker-compose restart minio

# Xem logs
docker-compose logs minio
```

### MySQL không start

```bash
# Xóa volume và tạo lại
docker-compose down -v
docker-compose up -d
```

## 📝 Notes

-   **MinIO Console**: Dùng để quản lý buckets, files qua giao diện web
-   **Public Access**: Bucket `laravel-images` được set public download, có thể truy cập trực tiếp qua URL
-   **Development**: Setup này phù hợp cho development, production cần thêm security
-   **Backup**: Nên backup MySQL và MinIO data thường xuyên

## 🚀 Production Deployment

Để deploy production, cần:

1. Đổi passwords trong `.env`
2. Set `APP_DEBUG=false`
3. Cấu hình SSL/HTTPS
4. Set private cho MinIO bucket nếu cần
5. Sử dụng nginx proxy với rate limiting
6. Setup backup tự động

---

**Happy Coding! 🎉**
