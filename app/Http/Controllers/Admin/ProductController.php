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
        $products = Product::all();
        return view('admin.product',compact('products'));
    }
}
