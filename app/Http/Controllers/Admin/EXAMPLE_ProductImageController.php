<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    /**
     * Example: Upload product với MinIO
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;

        // Upload main image lên MinIO
        if ($request->hasFile('main_image')) {
            $product->image = ImageService::upload($request->file('main_image'), 'products');
        }

        // Upload additional images
        if ($request->hasFile('additional_images')) {
            $urls = ImageService::uploadMultiple($request->file('additional_images'), 'products');
            $product->additional_images = $urls;
        }

        $product->save();

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được tạo thành công!');
    }

    /**
     * Example: Update product với MinIO
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $product->name = $request->name;
        $product->price = $request->price;

        // Upload main image mới và xóa ảnh cũ
        if ($request->hasFile('main_image')) {
            // Xóa ảnh cũ nếu có
            if ($product->image) {
                ImageService::delete($product->image);
            }

            // Upload ảnh mới
            $product->image = ImageService::upload($request->file('main_image'), 'products');
        }

        // Upload additional images mới
        if ($request->hasFile('additional_images')) {
            // Xóa ảnh cũ nếu có
            if ($product->additional_images && is_array($product->additional_images)) {
                ImageService::deleteMultiple($product->additional_images);
            }

            // Upload ảnh mới
            $urls = ImageService::uploadMultiple($request->file('additional_images'), 'products');
            $product->additional_images = $urls;
        }

        $product->save();

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được cập nhật!');
    }

    /**
     * Example: Delete product và xóa ảnh trên MinIO
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Xóa main image
        if ($product->image) {
            ImageService::delete($product->image);
        }

        // Xóa additional images
        if ($product->additional_images && is_array($product->additional_images)) {
            ImageService::deleteMultiple($product->additional_images);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được xóa!');
    }
}
