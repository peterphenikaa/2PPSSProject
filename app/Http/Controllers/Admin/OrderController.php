<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderItem;
class OrderController
{
    public function order()
    {
        $orderCount = Order::count();
        $monthlyRevenue = Order::whereMonth('created_at', now()->month)->sum('total_price');
        $productCount = Product::count();
        $recentOrders = Order::with(['user', 'orderItems.product'])->latest()->take(5)->get();
        $customerCount = User::where('role', 'user')->count();
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        return view('admin.order',compact(
            'orderCount',
            'monthlyRevenue',
            'recentOrders',
            'productCount',
            'customerCount',
            'recentOrders'
        ));
    }
}
