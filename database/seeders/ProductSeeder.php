<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Tắt kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('product_images')->truncate();
        DB::table('products')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $products = [
            [
                'name' => 'Nike Air Max 90',
                'brand' => 'Nike',
                'category' => 'Sneakers',
                'description' => 'Giày thể thao Nike Air Max 90 với thiết kế iconic, đệm khí Max Air mang lại sự thoải mái tối đa.',
                'price' => 3500000,
                'stock' => 50,
                'colorway' => 'White/Black/Red',
                'gender' => 'Unisex',
            ],
            [
                'name' => 'Adidas Ultraboost 22',
                'brand' => 'Adidas',
                'category' => 'Running',
                'description' => 'Giày chạy bộ Adidas Ultraboost 22 với công nghệ Boost mang lại năng lượng hoàn hảo cho mỗi bước chạy.',
                'price' => 4200000,
                'stock' => 40,
                'colorway' => 'Core Black/White',
                'gender' => 'Male',
            ],
            [
                'name' => 'Puma RS-X³',
                'brand' => 'Puma',
                'category' => 'Lifestyle',
                'description' => 'Puma RS-X³ kết hợp phong cách retro với công nghệ hiện đại, tạo nên đôi giày độc đáo và năng động.',
                'price' => 2800000,
                'stock' => 35,
                'colorway' => 'Blue/Yellow/White',
                'gender' => 'Unisex',
            ],
            [
                'name' => 'Vans Old Skool',
                'brand' => 'Vans',
                'category' => 'Skateboarding',
                'description' => 'Vans Old Skool - biểu tượng của văn hóa skate với thiết kế sọc jazz đặc trưng và độ bền cao.',
                'price' => 1800000,
                'stock' => 60,
                'colorway' => 'Black/White',
                'gender' => 'Unisex',
            ],
            [
                'name' => 'New Balance 574',
                'brand' => 'New Balance',
                'category' => 'Casual',
                'description' => 'New Balance 574 với thiết kế cổ điển, kết hợp giữa phong cách và sự thoải mái cho mọi hoạt động hàng ngày.',
                'price' => 2500000,
                'stock' => 45,
                'colorway' => 'Grey/Navy',
                'gender' => 'Female',
            ],
        ];

        foreach ($products as $index => $productData) {
            // Tạo product
            $product = Product::create([
                'name' => $productData['name'],
                'brand' => $productData['brand'],
                'category' => $productData['category'],
                'description' => $productData['description'],
                'available_sizes' => ['38', '39', '40', '41', '42', '43'],
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'colorway' => $productData['colorway'],
                'gender' => $productData['gender'],
                'is_featured' => false,
                'ratings' => rand(3, 5),
            ]);

            // Tạo 5 ảnh cho mỗi sản phẩm và upload lên MinIO
            $productFolder = 'products/product-' . $product->id;

            for ($i = 1; $i <= 5; $i++) {
                // Tạo ảnh placeholder
                $imagePath = $this->createPlaceholderImage($product->name, $i);

                // Upload lên MinIO
                $fileName = 'image-' . $i . '.jpg';
                $minioPath = $productFolder . '/' . $fileName;

                Storage::disk('minio')->put(
                    $minioPath,
                    file_get_contents($imagePath)
                );

                // Xóa file tạm
                @unlink($imagePath);

                // Lưu vào product_images
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $minioPath,
                    'order' => $i, // order=1 là ảnh chính
                ]);
            }
        }

        $this->command->info('✅ Đã seed 5 sản phẩm với 25 ảnh tổng cộng lên MinIO!');
    }

    private function createPlaceholderImage(string $productName, int $imageNumber): string
    {
        // Tạo ảnh 800x800
        $width = 800;
        $height = 800;

        $image = imagecreatetruecolor($width, $height);

        // Random màu nền
        $colors = [
            [135, 206, 250], // Sky blue
            [255, 182, 193], // Pink
            [144, 238, 144], // Light green
            [255, 218, 185], // Peach
            [221, 160, 221], // Plum
        ];

        $colorIndex = ($imageNumber - 1) % count($colors);
        $bgColor = imagecolorallocate($image, ...$colors[$colorIndex]);
        imagefill($image, 0, 0, $bgColor);

        // Màu text
        $textColor = imagecolorallocate($image, 50, 50, 50);

        // Vẽ text
        $text1 = substr($productName, 0, 20);
        $text2 = "Image #$imageNumber";

        // Tính toán vị trí căn giữa
        $fontSize = 5;
        $x1 = ($width - strlen($text1) * imagefontwidth($fontSize)) / 2;
        $x2 = ($width - strlen($text2) * imagefontwidth($fontSize)) / 2;

        imagestring($image, $fontSize, $x1, $height / 2 - 20, $text1, $textColor);
        imagestring($image, $fontSize, $x2, $height / 2 + 10, $text2, $textColor);

        // Lưu vào file tạm
        $tempPath = sys_get_temp_dir() . '/product_' . time() . '_' . $imageNumber . '.jpg';
        imagejpeg($image, $tempPath, 90);
        imagedestroy($image);

        return $tempPath;
    }
}