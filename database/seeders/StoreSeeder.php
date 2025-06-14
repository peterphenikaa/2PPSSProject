<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        Store::insert([
            [
                'name' => '2PSS Sneaker',
                'address' => 'Đại học Phenikaa, Nguyễn Trác, Yên Nghĩa',
                'city' => 'Hà Đông',
                'province' => 'Hà Nội',
                'country' => 'Vietnam',
                'phone' => '024-12345678',
                'email' => 'phenikaa@2pss.vn',
                'latitude' => 20.980118,
                'longitude' => 105.758644,
                'opening_hours' => '8:00 - 22:00',
                'status' => 'open',
            ],
            [
                'name' => '2PSS Sneaker',
                'address' => 'Yên Phong',
                'city' => 'Yên Phong',
                'province' => 'Bắc Ninh',
                'country' => 'Vietnam',
                'phone' => '0222-111111',
                'email' => 'yenphong@2pss.vn',
                'latitude' => 21.183333,
                'longitude' => 106.016667,
                'opening_hours' => '8:00 - 21:00',
                'status' => 'open',
            ],
            [
                'name' => '2PSS Sneaker',
                'address' => 'Thuận Thành',
                'city' => 'Thuận Thành',
                'province' => 'Bắc Ninh',
                'country' => 'Vietnam',
                'phone' => '0222-222222',
                'email' => 'thuanthanh@2pss.vn',
                'latitude' => 21.033333,
                'longitude' => 106.116667,
                'opening_hours' => '8:00 - 21:00',
                'status' => 'open',
            ],
            [
                'name' => '2PSS Sneaker',
                'address' => 'Lục Nam',
                'city' => 'Lục Nam',
                'province' => 'Bắc Giang',
                'country' => 'Vietnam',
                'phone' => '0204-333333',
                'email' => 'lucnam@2pss.vn',
                'latitude' => 21.283333,
                'longitude' => 106.533333,
                'opening_hours' => '8:00 - 20:00',
                'status' => 'open',
            ],
            [
                'name' => '2PSS Sneaker',
                'address' => 'Bắc Giang',
                'city' => 'Bắc Giang',
                'province' => 'Bắc Giang',
                'country' => 'Vietnam',
                'phone' => '0204-444444',
                'email' => 'bacgiang@2pss.vn',
                'latitude' => 21.281992,
                'longitude' => 106.197784,
                'opening_hours' => '8:00 - 20:00',
                'status' => 'open',
            ],
        ]);
    }
} 