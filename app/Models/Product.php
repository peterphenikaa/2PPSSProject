<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'main_image',
        'additional_images',
        'available_sizes',
        'price',
        'stock',
        'colorway',
        'style_code',
        'gender',
        'is_featured',
        'ratings',
    ];

    protected $casts = [
        'available_sizes' => 'array',
        'additional_images' => 'array',
        'is_featured' => 'boolean',
    ];
    public function images()
{
    return $this->hasMany(ProductImage::class)->orderBy('order');
}

}