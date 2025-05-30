<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController
{
    public function dashboard()
    {
        $orderCount = Order::count();
        $monthlyRevenue = Order::whereMonth('created_at', now()->month)->sum('total_price');
        $productCount = Product::count();
        $customerCount = User::where('role', 'user')->count();

        $recentOrders = Order::with('user')->latest()->take(5)->get();

        $revenueLabels = ['T1', 'T2', 'T3', 'T4', 'T5', 'T6'];
        $revenueData = [15000000, 12000000, 18000000, 22000000, 9000000, 19500000];

        return view('admin.dashboard', compact(
            'orderCount',
            'monthlyRevenue',
            'productCount',
            'customerCount',
            'recentOrders',
            'revenueLabels',
            'revenueData'
        ));
    }
}
