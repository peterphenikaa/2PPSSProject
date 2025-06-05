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
    public function search(Request $request)
    {
        $q = $request->input('q');
        $orders = Order::with('user')
            ->when($q, function ($query) use ($q) {
                $query->where('id', 'like', "%$q%")
                    ->orWhereHas('user', function ($userQuery) use ($q) {
                        $userQuery->where('name', 'like', "%$q%")
                            ->orWhere('email', 'like', "%$q%") ;
                    })
                    ->orWhere('status', 'like', "%$q%") ;
            })
            ->latest()
            ->paginate(10);
        return view('admin.order', [
            'recentOrders' => $orders,
            // ...truyền thêm các biến khác nếu cần...
        ]);
    }
}
