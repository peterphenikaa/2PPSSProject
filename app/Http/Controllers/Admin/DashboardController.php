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

        // Doanh thu 6 tháng gần nhất
        $revenueLabels = [];
        $revenueData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenueLabels[] = 'T' . $month->format('n');
            $revenueData[] = Order::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_price');
        }

        // Phân loại đơn hàng
        $statusLabels = [
            'Đã giao',
            'Đang giao hàng',
            'Đã hủy',
            'Chờ xác nhận',
        ];
        $statusData = [];
        foreach ($statusLabels as $status) {
            $statusData[] = Order::where('status', $status)->count();
        }

        return view('admin.dashboard', compact(
            'orderCount',
            'monthlyRevenue',
            'productCount',
            'customerCount',
            'recentOrders',
            'revenueLabels',
            'revenueData',
            'statusLabels',
            'statusData',
        ));
    }
}
