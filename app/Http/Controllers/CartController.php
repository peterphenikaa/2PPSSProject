<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    
    public function index()
    {
        $cart = session()->get('cart', []);
        
        $productIds = array_map(fn($item) => $item['product_id'], $cart);
       
        $products = Product::findMany($productIds)->keyBy('id');

        return view('cart.index', compact('cart', 'products'));
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);
        $productId = $request->product_id;
        $size = $request->size;
        $quantity = (int)$request->quantity;
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);
        $cartItemId = $productId . '_' . $size; 
        if (isset($cart[$cartItemId])) {
            $cart[$cartItemId]['quantity'] += $quantity;
        } else {
            $cart[$cartItemId] = [
                'product_id' => $productId,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'size' => $size,
                'quantity' => $quantity,
            ];
        }
        session()->put('cart', $cart);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => 'Đã thêm sản phẩm vào giỏ hàng!',
                'cart' => $cart,
                'cart_count' => count($cart)
            ]);
        }
        return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|string',
        ]);
        $cart = session()->get('cart', []);
        $cartItemId = $request->id;
        
        if (!isset($cart[$cartItemId])) {
            return back()->with('error', 'Sản phẩm không có trong giỏ hàng.');
        }
        $item = $cart[$cartItemId];
        unset($cart[$cartItemId]);
        $newCartItemId = $item['product_id'] . '_' . $request->size;
        $item['size'] = $request->size;
        $item['quantity'] = (int)$request->quantity;
        if (isset($cart[$newCartItemId])) {
             $cart[$newCartItemId]['quantity'] += $item['quantity'];
        } else {
             $cart[$newCartItemId] = $item;
        }
        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật thành công!');
    }

    public function remove(Request $request)
    {
        $request->validate(['id' => 'required|string']);
        
        $cart = session()->get('cart', []);
        $cartItemId = $request->id;

        if (isset($cart[$cartItemId])) {
            unset($cart[$cartItemId]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng thành công.');
        }

        return redirect()->route('cart.index')->with('error', 'Không tìm thấy sản phẩm để xóa.');
    }

    public function checkoutForm(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }
        $total = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
        return view('cart.checkout', compact('cart', 'total'));
    }

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
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }
        $totalPrice = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        $order = Order::create([
            'user_id' => Auth::id(),
            'recipient_name' => $validated['recipient_name'],
            'recipient_phone' => $validated['recipient_phone'],
            'province' => $validated['province'],
            'district' => $validated['district'],
            'ward' => $validated['ward'],
            'address_detail' => $validated['address_detail'],
            'payment_method' => $validated['payment_method'],
            'total_price' => $totalPrice,
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