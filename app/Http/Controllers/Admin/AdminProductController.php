<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        $products = $query->orderByDesc('created_at')->paginate(10);
        $brands = Product::select('brand')->distinct()->pluck('brand');
        $categories = Product::select('category')->distinct()->pluck('category');
        return view('admin.products.index', compact('products', 'brands', 'categories'));
    }
    public function create() {
        $brands = Product::select('brand')->distinct()->pluck('brand');
        $categories = Product::select('category')->distinct()->pluck('category');
        return view('admin.products.create', compact('brands', 'categories'));
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|string',
            'available_sizes' => 'required',
            'gender' => 'required',
            'colorway' => 'required',
            'stock' => 'required|integer',
            'brand' => 'required',
            'category' => 'required',
        ]);
        $validated['available_sizes'] = json_encode(explode(',', $validated['available_sizes']));
        Product::create($validated);
        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }
    public function edit($id) {
        $product = Product::findOrFail($id);
        $brands = Product::select('brand')->distinct()->pluck('brand');
        $categories = Product::select('category')->distinct()->pluck('category');
        return view('admin.products.edit', compact('product', 'brands', 'categories'));
    }
    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|string',
            'available_sizes' => 'required',
            'gender' => 'required',
            'colorway' => 'required',
            'stock' => 'required|integer',
            'brand' => 'required',
            'category' => 'required',
        ]);
        $validated['available_sizes'] = json_encode(explode(',', $validated['available_sizes']));
        $product->update($validated);
        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }
    public function destroy($id) {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công!');
    }
} 