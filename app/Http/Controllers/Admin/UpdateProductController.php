<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateProductController extends Controller
{
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.updateproduct', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'brand' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:male,female,unisex',
            'colorway' => 'nullable|string|max:255',
            'available_sizes' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);
        $validated['available_sizes'] = array_map('trim', explode(',', $request->available_sizes));
        if ($request->hasFile('image')) {
            if ($product->image && Storage::exists($product->image)) {
                Storage::delete($product->image);
            }
            $path = $request->file('image')->store('product_images', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        return redirect()->route('admin.products.edit', $product->id)->with('success', 'Cập nhật thành công!');
    }
}
