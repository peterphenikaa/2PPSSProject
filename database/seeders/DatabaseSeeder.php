<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use App\Models\ProductImage;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('Admin123@'),
            'role' => 'admin',
        ]);
        $userId1 = DB::table('users')->insertGetId([
            'name' => 'Thanh Binh',
            'email' => 'thanhbinh2k5@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'user',
        ]);
        $userId2 = DB::table('users')->insertGetId([
            'name' => 'Ba Thien',
            'email' => 'pathin2k5@gmail.com',
            'password' => Hash::make('bathien332005@'),
            'role' => 'user',
        ]);

        // Seed products
        $this->call(ProductSeeder::class);

        $product1 = Product::create([
            'name' => 'Nike Air Max 97',
            'description' => 'Phong cách thể thao, thoải mái',
            'price' => 3200000,
            'image' => 'nike_airmax97.jpg',
            'available_sizes' => ['38', '39', '40', '41'],
            'gender' => 'unisex',
            'colorway' => 'Trắng/Đỏ',
            'stock' => 20,
            'brand' => 'Nike',
            'category' => 'Chạy bộ',
        ]);

        $product2 = Product::create([
            'name' => 'Adidas Ultraboost 22',
            'description' => 'Siêu nhẹ, siêu êm',
            'price' => 2900000,
            'image' => 'adidas_ultraboost.jpg',
            'available_sizes' => ['40', '41', '42'],
            'gender' => 'male',
            'colorway' => 'Đen/Xanh',
            'stock' => 15,
            'brand' => 'Adidas',
            'category' => 'Thể thao',
        ]);

        $images = [
            ['product_id' => 1, 'image_path' => 'nike_airmax97.jpg', 'order' => 1],
            ['product_id' => 1, 'image_path' => 'nike_airmax97.jpg', 'order' => 2],
            ['product_id' => 1, 'image_path' => 'nike_airmax97.jpg', 'order' => 3],
            ['product_id' => 1, 'image_path' => 'nike_airmax97.jpg', 'order' => 4],
        ];

        foreach ($images as $image) {
            ProductImage::create($image);
        }

        // Seed order
        $order1 = Order::create([
            'user_id' => $userId1,
            'recipient_name' => 'Nguyễn Văn A',
            'recipient_phone' => '0909123456',
            'province' => 'Hà Nội',
            'district' => 'Hai Bà Trưng',
            'ward' => 'Phường Bạch Mai',
            'address_detail' => '123 phố Huế',
            'payment_method' => 'cod',
            'total_price' => 6100000,
            'status' => 'Đã giao',
            'created_at' => Carbon::now()->subDays(1),
        ]);

        $order2 = Order::create([
            'user_id' => $userId2,
            'recipient_name' => 'Trần Thị B',
            'recipient_phone' => '0911123456',
            'province' => 'TP HCM',
            'district' => 'Quận 1',
            'ward' => 'Phường Bến Nghé',
            'address_detail' => '456 Lê Duẩn',
            'payment_method' => 'bank_transfer',
            'total_price' => 1100000,
            'status' => 'Chưa giao',
            'created_at' => Carbon::now()->subDays(1),
        ]);

        // Seed order items
        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $product1->id,
            'quantity' => 1,
            'price' => 3200000,
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $product2->id,
            'quantity' => 1,
            'price' => 2900000,
            'size' => '37',
        ]);
        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $product1->id,
            'quantity' => 1,
            'price' => 2900000,
            'size' => '40',
        ]);

        // Seed stores
        $this->call(StoreSeeder::class);
        // Seed blogs
        $this->call(BlogSeeder::class);

        // Tự động cập nhật ngày tạo và cập nhật gần nhất cho user bị thiếu
        DB::table('users')->whereNull('created_at')->update(['created_at' => Carbon::now()]);
        DB::table('users')->whereNull('updated_at')->update(['updated_at' => Carbon::now()]);
    }
}
