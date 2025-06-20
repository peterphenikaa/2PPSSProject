<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Tắt kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('product_images')->truncate();
        DB::table('products')->truncate();
        // Bật lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $imageFiles = File::files(public_path('images'));
        $imageGroups = [];
        foreach ($imageFiles as $file) {
            $name = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            if (preg_match('/^(.+)-(\d)$/', $name, $matches)) {
                $baseName = $matches[1];
                $imageGroups[$baseName][] = $file->getFilename();
            }
        }
        foreach ($imageGroups as $baseName => $images) {
            sort($images, SORT_NATURAL); // Đảm bảo thứ tự 1-5
            // Chỉ tạo sản phẩm khi đủ 5 ảnh
            if (count($images) === 5) {
                $product = Product::create([
                    'name' => ucwords(str_replace('-', ' ', $baseName)),
                    'category' => 'Sneakers',
                    'description' => 'Mô tả sản phẩm ' . $baseName,
                    // 'main_image' => $images[0], // 1 là ảnh chính
                    'available_sizes' => ['38', '39', '40', '41', '42', '43'],
                    'price' => rand(1000000, 5000000),
                    'stock' => rand(10, 100),
                    'colorway' => 'Black/White',
                    'gender' => 'Unisex',
                    'is_featured' => false,
                    'ratings' => rand(1, 5),
                ]);
                // 2-5 là ảnh phụ
                foreach (array_slice($images, 1, 4) as $index => $image) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $image,
                        'order' => $index + 1,
                    ]);
                }
            }
        }
    }
} 