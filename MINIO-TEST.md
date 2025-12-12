# MinIO Configuration Test

Để test MinIO hoạt động đúng, làm theo các bước:

## 1. Kiểm tra MinIO đang chạy

```bash
docker-compose ps
```

Phải thấy container `laravel_minio` đang UP.

## 2. Truy cập MinIO Console

Mở browser: http://localhost:9001

Login:

-   User: `minioadmin`
-   Pass: `minioadmin123`

Phải thấy bucket `laravel-images` đã được tạo.

## 3. Test upload từ Laravel

Tạo route test:

```php
// routes/web.php
Route::get('/test-minio', function() {
    try {
        // Test connection
        $disk = Storage::disk('minio');

        // Create test file
        $content = 'Test MinIO upload at ' . now();
        $disk->put('test/test.txt', $content);

        // Get URL
        $url = $disk->url('test/test.txt');

        // Check exists
        $exists = $disk->exists('test/test.txt');

        return response()->json([
            'status' => 'success',
            'url' => $url,
            'exists' => $exists,
            'message' => 'MinIO is working!'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});
```

Truy cập: http://localhost:8080/test-minio

## 4. Kiểm tra file đã upload

-   Vào MinIO Console: http://localhost:9001
-   Click vào bucket `laravel-images`
-   Phải thấy folder `test` với file `test.txt`

## 5. Test download

Copy URL từ response ở bước 3, paste vào browser.

Phải download được file `test.txt` với nội dung là timestamp.

## 6. Test với ảnh thật

```php
Route::post('/test-minio-image', function(Request $request) {
    $request->validate([
        'image' => 'required|image|max:5120'
    ]);

    $url = \App\Services\ImageService::upload($request->file('image'), 'test');

    return response()->json([
        'status' => 'success',
        'url' => $url,
        'message' => 'Image uploaded to MinIO!'
    ]);
});
```

Test bằng Postman hoặc form:

```html
<form action="/test-minio-image" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image" accept="image/*" />
    <button type="submit">Upload Test Image</button>
</form>
```

## 7. Troubleshooting

### Lỗi: Connection refused

```bash
# Restart MinIO
docker-compose restart minio

# Check logs
docker-compose logs minio
```

### Lỗi: Bucket không tồn tại

```bash
# Vào MinIO client
docker-compose exec minio-client sh

# List buckets
mc ls myminio

# Tạo bucket manually
mc mb myminio/laravel-images

# Set public
mc anonymous set download myminio/laravel-images
```

### Lỗi: SignatureDoesNotMatch

-   Kiểm tra AWS_ACCESS_KEY_ID và AWS_SECRET_ACCESS_KEY trong .env
-   Phải khớp với MINIO_ROOT_USER và MINIO_ROOT_PASSWORD trong docker-compose.yml

### Lỗi: 403 Forbidden

-   Kiểm tra bucket policy
-   Đảm bảo `AWS_USE_PATH_STYLE_ENDPOINT=true` trong .env

## 8. Cleanup test files

```bash
docker-compose exec app php artisan tinker

# Trong tinker:
Storage::disk('minio')->deleteDirectory('test');
```

---

Nếu tất cả test pass ✅, MinIO đã sẵn sàng cho production!
