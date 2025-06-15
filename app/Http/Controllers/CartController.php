<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index(Request $request)
    {
        $cart = session('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Thêm sản phẩm vào giỏ hàng
    public function add(Request $request)
    {
        $data = $request->all();
        $productId = $data['product_id'];
        $size = $data['size'];
        $quantity = isset($data['quantity']) ? (int)$data['quantity'] : 1;

        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
        }

        $cart = session('cart', []);
        $key = $productId . '_' . $size;
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[$key] = [
                'product_id' => $productId,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image ?? null,
                'size' => $size,
                'quantity' => $quantity,
            ];
        }
        session(['cart' => $cart]);
        return response()->json(['success' => true]);
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function update(Request $request)
    {
        $key = $request->input('key');
        $quantity = (int)$request->input('quantity');
        $cart = session('cart', []);
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $quantity;
            session(['cart' => $cart]);
        }
        return redirect()->route('cart.index');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove(Request $request)
    {
        $key = $request->input('key');
        $cart = session('cart', []);
        if (isset($cart[$key])) {
            unset($cart[$key]);
            session(['cart' => $cart]);
        }
        return redirect()->route('cart.index');
    }

    // Hiển thị form checkout
    public function checkoutForm(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }
        return view('cart.checkout', compact('cart'));
    }

    // Xử lý lưu đơn hàng
    public function checkoutSubmit(Request $request)
    {
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'province' => 'required|string',
            'district' => 'required|string',
            'ward' => 'required|string',
            'address_detail' => 'required|string|max:255',
            'payment_method' => 'required|string',
        ]);
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }
        $order = Order::create([
            'user_id' => Auth::id(),
            'recipient_name' => $validated['recipient_name'],
            'recipient_phone' => $validated['recipient_phone'],
            'province' => $validated['province'],
            'district' => $validated['district'],
            'ward' => $validated['ward'],
            'address_detail' => $validated['address_detail'],
            'payment_method' => $validated['payment_method'],
            'total_price' => array_sum(array_map(function($item) { return $item['price'] * $item['quantity']; }, $cart)),
            'status' => strpos($validated['payment_method'], 'momo') !== false ? 'Chờ thanh toán Momo' : 'Chờ xác nhận',
        ]);
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'size' => $item['size'],
            ]);
        }
        if (strpos($validated['payment_method'], 'momo') !== false) {
            return redirect()->route('cart.momo_qr', ['order' => $order->id]);
        }
        session()->forget('cart');
        return redirect('/')->with('success', 'Đặt hàng thành công!');
    }

    public function showMomoQR($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('cart.momo-qr', compact('order'));
    }
} 