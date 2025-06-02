<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
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
        $product1 = Product::create([
            'name' => 'Nike Air Max 97',
            'description' => 'Phong cách thể thao, thoải mái',
            'price' => 3200000,
            'image' => 'nike_airmax97.jpg',
            'available_sizes' =>['38', '39', '40', '41'],
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
        
        

        // Seed order
        $order1 = Order::create([
            'user_id' => $userId1,
            'total_price' => 6100000,
            'status' => 'Đã giao',
            'created_at' => Carbon::now()->subDays(1),
        ]);
        $order2 = Order::create([
            'user_id' => $userId2,
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
        ]);
        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $product1->id,
            'quantity' => 1,
            'price' => 2900000,
        ]);
    }
}
