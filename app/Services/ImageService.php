<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Upload ảnh lên MinIO
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder (products, blogs, users, etc)
     * @return string URL của ảnh
     */
    public static function upload($file, $folder = 'images')
    {
        // Tạo tên file unique
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        // Upload lên MinIO
        $path = Storage::disk('minio')->putFileAs($folder, $file, $filename);

        // Trả về URL đầy đủ
        return Storage::disk('minio')->url($path);
    }

    /**
     * Upload nhiều ảnh
     * 
     * @param array $files
     * @param string $folder
     * @return array URLs
     */
    public static function uploadMultiple($files, $folder = 'images')
    {
        $urls = [];

        foreach ($files as $file) {
            $urls[] = self::upload($file, $folder);
        }

        return $urls;
    }

    /**
     * Xóa ảnh từ MinIO
     * 
     * @param string $url Hoặc path
     * @return bool
     */
    public static function delete($url)
    {
        // Nếu là URL đầy đủ, extract path
        if (Str::startsWith($url, 'http')) {
            $url = self::extractPathFromUrl($url);
        }

        return Storage::disk('minio')->delete($url);
    }

    /**
     * Xóa nhiều ảnh
     * 
     * @param array $urls
     * @return bool
     */
    public static function deleteMultiple($urls)
    {
        $paths = [];

        foreach ($urls as $url) {
            if (Str::startsWith($url, 'http')) {
                $paths[] = self::extractPathFromUrl($url);
            } else {
                $paths[] = $url;
            }
        }

        return Storage::disk('minio')->delete($paths);
    }

    /**
     * Extract path từ URL
     * 
     * @param string $url
     * @return string
     */
    private static function extractPathFromUrl($url)
    {
        // http://localhost:9000/laravel-images/products/image.jpg
        // => products/image.jpg

        $bucket = env('AWS_BUCKET', 'laravel-images');
        $parts = explode($bucket . '/', $url);

        return isset($parts[1]) ? $parts[1] : $url;
    }

    /**
     * Kiểm tra file có tồn tại không
     * 
     * @param string $path
     * @return bool
     */
    public static function exists($path)
    {
        return Storage::disk('minio')->exists($path);
    }

    /**
     * Lấy URL từ path
     * 
     * @param string $path
     * @return string
     */
    public static function url($path)
    {
        return Storage::disk('minio')->url($path);
    }

    /**
     * Copy ảnh từ local public path lên MinIO
     * Dùng để migrate ảnh cũ
     * 
     * @param string $localPath (e.g., 'images/product.jpg' from public/)
     * @param string $folder (e.g., 'products')
     * @return string|false URL mới hoặc false nếu thất bại
     */
    public static function migrateFromPublic($localPath, $folder = 'migrated')
    {
        $fullPath = public_path($localPath);

        if (!file_exists($fullPath)) {
            return false;
        }

        $filename = basename($localPath);
        $fileContent = file_get_contents($fullPath);

        // Upload lên MinIO
        $path = $folder . '/' . $filename;
        Storage::disk('minio')->put($path, $fileContent);

        return Storage::disk('minio')->url($path);
    }
}
