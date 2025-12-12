<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('blogs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $blogs = [
            [
                'title' => 'Top 10 Đôi Giày Sneaker Hot Nhất 2025',
                'content' => '<h2>Khám phá những mẫu sneaker hot nhất</h2><p>Năm 2025 mang đến những thiết kế độc đáo và công nghệ tiên tiến. Từ Nike Air Max đến Adidas Ultraboost, những đôi giày này không chỉ mang lại sự thoải mái mà còn thể hiện phong cách thời trang của bạn.</p>',
                'status' => 'published',
            ],
            [
                'title' => 'Cách Phối Đồ Với Giày Thể Thao',
                'content' => '<h2>Hướng dẫn phối đồ streetwear</h2><p>Từ streetwear đến smart casual, giày thể thao có thể kết hợp với nhiều loại trang phục khác nhau để tạo nên những bộ outfit ấn tượng. Áo phông + quần jeans + sneaker trắng là combo kinh điển không bao giờ lỗi mốt.</p>',
                'status' => 'published',
            ],
            [
                'title' => 'Bí Quyết Chọn Size Giày Phù Hợp',
                'content' => '<h2>Cách đo size chính xác</h2><p>Việc chọn đúng size không chỉ giúp bạn thoải mái khi mang mà còn kéo dài tuổi thọ của đôi giày yêu thích. Hãy đo chân vào buổi chiều khi chân hơi phồng lên để có số đo chính xác nhất.</p>',
                'status' => 'published',
            ],
        ];

        foreach ($blogs as $index => $blogData) {
            // Tạo ảnh placeholder cho blog
            $imagePath = $this->createBlogImage($blogData['title'], $index + 1);

            // Upload lên MinIO
            $fileName = 'blog-' . Str::slug($blogData['title']) . '.jpg';
            $minioPath = 'blogs/' . $fileName;

            Storage::disk('minio')->put(
                $minioPath,
                file_get_contents($imagePath)
            );

            // Xóa file tạm
            @unlink($imagePath);

            // Tạo blog
            Blog::create([
                'title' => $blogData['title'],
                'slug' => Str::slug($blogData['title']),
                'content' => $blogData['content'],
                'image' => $minioPath,
                'status' => $blogData['status'],
                'author_id' => 1,
            ]);
        }

        $this->command->info('✅ Đã seed 3 bài blog với ảnh lên MinIO!');
    }

    private function createBlogImage(string $title, int $number): string
    {
        // Tạo ảnh 1200x630 (tỉ lệ OG image)
        $width = 1200;
        $height = 630;

        $image = imagecreatetruecolor($width, $height);

        // Gradient background colors
        $gradients = [
            [[25, 118, 210], [33, 150, 243]], // Blue gradient
            [[233, 30, 99], [244, 143, 177]],  // Pink gradient
            [[76, 175, 80], [129, 199, 132]],  // Green gradient
        ];

        $gradIndex = ($number - 1) % count($gradients);

        // Simple gradient fill
        for ($i = 0; $i < $height; $i++) {
            $ratio = $i / $height;
            $r = (int) ($gradients[$gradIndex][0][0] * (1 - $ratio) + $gradients[$gradIndex][1][0] * $ratio);
            $g = (int) ($gradients[$gradIndex][0][1] * (1 - $ratio) + $gradients[$gradIndex][1][1] * $ratio);
            $b = (int) ($gradients[$gradIndex][0][2] * (1 - $ratio) + $gradients[$gradIndex][1][2] * $ratio);
            $lineColor = imagecolorallocate($image, $r, $g, $b);
            imageline($image, 0, $i, $width, $i, $lineColor);
        }

        // Text color
        $textColor = imagecolorallocate($image, 255, 255, 255);

        // Draw title (wrap text if too long)
        $fontSize = 5;
        $maxWidth = 60;
        $words = explode(' ', $title);
        $line = '';
        $y = $height / 2 - 30;

        foreach ($words as $word) {
            if (strlen($line . $word) > $maxWidth) {
                $x = ($width - strlen($line) * imagefontwidth($fontSize)) / 2;
                imagestring($image, $fontSize, $x, $y, $line, $textColor);
                $line = $word . ' ';
                $y += 20;
            } else {
                $line .= $word . ' ';
            }
        }

        if ($line) {
            $x = ($width - strlen($line) * imagefontwidth($fontSize)) / 2;
            imagestring($image, $fontSize, $x, $y, $line, $textColor);
        }

        // Lưu vào file tạm
        $tempPath = sys_get_temp_dir() . '/blog_' . time() . '_' . $number . '.jpg';
        imagejpeg($image, $tempPath, 90);
        imagedestroy($image);

        return $tempPath;
    }
}