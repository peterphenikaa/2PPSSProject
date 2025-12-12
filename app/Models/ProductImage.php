<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
        'order',
    ];

    /**
     * Liên kết với bảng Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get full URL for the image from MinIO
     */
    public function getFullUrlAttribute()
    {
        if (!$this->image_path) {
            return null;
        }

        return rtrim(config('filesystems.disks.minio.url'), '/') . '/' . ltrim($this->image_path, '/');
    }
}
