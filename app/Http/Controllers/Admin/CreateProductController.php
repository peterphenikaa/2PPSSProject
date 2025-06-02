<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class CreateProductController extends Controller
{
    public function createProduct()
    {
        return view('admin.createproduct');
    }

    public function formProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'nullable|integer',
            'brand' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female,unisex',
            'colorway' => 'nullable|string|max:255',
            'available_sizes' => 'nullable|string', 
            'image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');
        // Tạo sản phẩm mới
        $product = new Product();
        $product->name = $validated['name'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->stock = $validated['stock'] ?? 0;
        $product->brand = $validated['brand'];
        $product->category = $validated['category'];
        $product->gender = $validated['gender'];
        $product->colorway = $validated['colorway'];
        $product->available_sizes = explode(',', $validated['available_sizes']);
        $product->image = $imagePath;
        $product->save();

        return redirect()->route('admin.products.create.form')->with('success', 'Sản phẩm đã được tạo thành công!');
    }
}
