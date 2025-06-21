<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

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
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'province' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'ward' => 'required|string|max:255',
            'address_detail' => 'required|string|max:255',
            'payment_method' => 'required|in:cod,momo_qr',
        ]);

        $order = Order::create([
            'user_id' => Auth::id() ?? null,
            'recipient_name' => $request->recipient_name,
            'recipient_phone' => $request->recipient_phone,
            'province' => $request->province,
            'district' => $request->district,
            'ward' => $request->ward,
            'address_detail' => $request->address_detail,
            'payment_method' => $request->payment_method,
            'total_price' => $request->price,
            'status' => $request->payment_method === 'momo_qr' ? 'Chờ thanh toán Momo' : 'Chờ xác nhận',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $request->product_id,
            'quantity' => 1,
            'price' => $request->price,
            'size' => $request->size,
        ]);

        if ($request->payment_method === 'momo_qr') {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['redirect_url' => route('cart.momo_qr', ['order' => $order->id])]);
            }
            return redirect()->route('cart.momo_qr', ['order' => $order->id]);
        }
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => 'Đặt hàng thành công!', 'redirect_url' => '/']);
        }

        return redirect('/')->with('success', 'Đặt hàng thành công!');
    }
    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        return view('admin.order-detail', compact('order'));
    }
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'status' => 'required|string|max:255',
        ]);
        $order->status = $request->status;
        $order->save();
        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Cập nhật trạng thái thành công!');
    }
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        // Xóa các order items liên quan trước để đảm bảo không có lỗi khóa ngoại
        $order->orderItems()->delete();
        $order->delete();
        return redirect()->route('admin.order')->with('success', 'Đã xóa đơn hàng thành công!');
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.order-edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'province' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'ward' => 'required|string|max:255',
            'address_detail' => 'required|string|max:255',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Đã cập nhật thông tin đơn hàng thành công!');
    }
}
