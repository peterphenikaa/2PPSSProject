<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;

class CreateProductController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

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
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:5120',
        ]);

        DB::beginTransaction();
        try {
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
            $product->save();

            // Upload images lên MinIO
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $this->imageService->upload($image, 'products');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'order' => $index + 1, // order từ 1 đến 5
                ]);
            }

            DB::commit();
            return redirect()->route('admin.products.create.form')->with('success', 'Sản phẩm đã được tạo thành công!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Lỗi khi tạo sản phẩm: ' . $e->getMessage()])->withInput();
        }
    }
}
