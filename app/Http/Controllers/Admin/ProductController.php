<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderItem;

class ProductController
{
    public function product()
    {
        $products = Product::all()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'sizes' => json_decode($product->available_sizes, true),
                'gender' => $product->gender,
                'brand' => $product->brand,
                'category' => $product->category,
                'colorway' => $product->colorway,
                'stock' => $product->stock,
            ];
        })->toArray();
        return view('admin.product', compact('products'));
    }
}
