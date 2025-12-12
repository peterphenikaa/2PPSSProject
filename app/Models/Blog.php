<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'status',
        'author_id',
    ];

    /**
     * Get full URL for the blog image from MinIO
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        return rtrim(config('filesystems.disks.minio.url'), '/') . '/' . ltrim($this->image, '/');
    }
}
