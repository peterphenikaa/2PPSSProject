<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        Blog::insert([
            [
                'title' => 'Top 5 mẫu sneaker hot nhất 2024',
                'slug' => Str::slug('Top 5 mẫu sneaker hot nhất 2024'),
                'content' => '<h2>1. Nike Air Max 97</h2><p>Thiết kế hiện đại, phối màu trẻ trung, phù hợp mọi outfit.</p><h2>2. Adidas Ultraboost 22</h2><p>Êm ái, nhẹ nhàng, cực kỳ phù hợp cho dân chạy bộ.</p><h2>3. Converse Chuck 70</h2><p>Biểu tượng bất tử của giới trẻ, dễ phối đồ.</p><h2>4. Puma RS-X</h2><p>Phong cách retro, cá tính mạnh mẽ.</p><h2>5. Vans Old Skool</h2><p>Đơn giản, chất, không bao giờ lỗi mốt.</p>',
                'image' => 'blog1.jpg',
                'status' => 'published',
                'author_id' => 1,
            ],
            [
                'title' => 'Cách bảo quản giày sneaker luôn như mới',
                'slug' => Str::slug('Cách bảo quản giày sneaker luôn như mới'),
                'content' => '<ul><li><strong>Vệ sinh định kỳ:</strong> Dùng bàn chải mềm và dung dịch chuyên dụng.</li><li><strong>Bảo quản nơi khô ráo:</strong> Tránh ánh nắng trực tiếp, độ ẩm cao.</li><li><strong>Nhét giấy báo:</strong> Giữ form giày, hút ẩm tốt.</li><li><strong>Không giặt máy:</strong> Dễ làm hỏng chất liệu và form giày.</li></ul>',
                'image' => 'blog2.jpg',
                'status' => 'published',
                'author_id' => 1,
            ],
            [
                'title' => 'Mix đồ với sneaker: 10 phong cách cực chất',
                'slug' => Str::slug('Mix đồ với sneaker: 10 phong cách cực chất'),
                'content' => '<p>Gợi ý phối đồ:</p><ul><li>Áo phông + quần jeans + sneaker trắng</li><li>Áo hoodie + quần jogger + sneaker màu nổi</li><li>Váy ngắn + sneaker cổ cao</li><li>Suit + sneaker trắng (phá cách)</li></ul>',
                'image' => 'blog3.jpg',
                'status' => 'published',
                'author_id' => 1,
            ],
            [
                'title' => 'Lịch sử phát triển của sneaker trên thế giới',
                'slug' => Str::slug('Lịch sử phát triển của sneaker trên thế giới'),
                'content' => '<p>Từ những năm 1800, sneaker đã phát triển vượt bậc, trở thành biểu tượng văn hóa toàn cầu. Các thương hiệu lớn như Nike, Adidas, Converse, Puma... đều góp phần tạo nên lịch sử này.</p>',
                'image' => 'blog4.jpg',
                'status' => 'published',
                'author_id' => 1,
            ],
        ]);
    }
} 