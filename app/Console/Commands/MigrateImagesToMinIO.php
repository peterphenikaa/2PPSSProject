<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Blog;
use App\Services\ImageService;

class MigrateImagesToMinIO extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:migrate-to-minio 
                            {--model=all : Model to migrate (all, products, blogs)}
                            {--dry-run : Preview changes without executing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate images from local storage to MinIO';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $model = $this->option('model');
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->warn('🔍 DRY RUN MODE - No changes will be made');
        }

        $this->info('🚀 Starting image migration to MinIO...');
        $this->newLine();

        if ($model === 'all' || $model === 'products') {
            $this->migrateProducts($dryRun);
        }

        if ($model === 'all' || $model === 'blogs') {
            $this->migrateBlogs($dryRun);
        }

        $this->newLine();
        $this->info('✅ Migration completed!');
    }

    /**
     * Migrate product images
     */
    private function migrateProducts($dryRun = false)
    {
        $this->info('📦 Migrating Product images...');

        $products = Product::all();
        $bar = $this->output->createProgressBar($products->count());
        $bar->start();

        $success = 0;
        $failed = 0;

        foreach ($products as $product) {
            try {
                // Migrate main image
                if ($product->image && !str_starts_with($product->image, 'http')) {
                    $localPath = 'images/' . $product->image;

                    if (!$dryRun) {
                        $newUrl = ImageService::migrateFromPublic($localPath, 'products');

                        if ($newUrl) {
                            $product->image = $newUrl;
                        }
                    } else {
                        $this->line("  Would migrate: {$localPath}");
                    }
                }

                // Migrate additional images if JSON array
                if ($product->additional_images && is_array($product->additional_images)) {
                    $newImages = [];

                    foreach ($product->additional_images as $image) {
                        if (!str_starts_with($image, 'http')) {
                            $localPath = 'images/' . $image;

                            if (!$dryRun) {
                                $newUrl = ImageService::migrateFromPublic($localPath, 'products');
                                $newImages[] = $newUrl ?: $image;
                            } else {
                                $this->line("  Would migrate: {$localPath}");
                                $newImages[] = $image;
                            }
                        } else {
                            $newImages[] = $image;
                        }
                    }

                    if (!$dryRun) {
                        $product->additional_images = $newImages;
                    }
                }

                if (!$dryRun) {
                    $product->save();
                }

                $success++;
            } catch (\Exception $e) {
                $this->error("  Failed for product {$product->id}: " . $e->getMessage());
                $failed++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("  ✅ Success: {$success} | ❌ Failed: {$failed}");
    }

    /**
     * Migrate blog images
     */
    private function migrateBlogs($dryRun = false)
    {
        $this->info('📝 Migrating Blog images...');

        $blogs = Blog::all();
        $bar = $this->output->createProgressBar($blogs->count());
        $bar->start();

        $success = 0;
        $failed = 0;

        foreach ($blogs as $blog) {
            try {
                if ($blog->image && !str_starts_with($blog->image, 'http')) {
                    $localPath = 'images/' . $blog->image;

                    if (!$dryRun) {
                        $newUrl = ImageService::migrateFromPublic($localPath, 'blogs');

                        if ($newUrl) {
                            $blog->image = $newUrl;
                            $blog->save();
                        }
                    } else {
                        $this->line("  Would migrate: {$localPath}");
                    }
                }

                $success++;
            } catch (\Exception $e) {
                $this->error("  Failed for blog {$blog->id}: " . $e->getMessage());
                $failed++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("  ✅ Success: {$success} | ❌ Failed: {$failed}");
    }
}
