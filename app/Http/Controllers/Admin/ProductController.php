<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderItem;

class ProductController
{
    public function product()
    {
        $products = Product::all()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'sizes' => $product->available_sizes,
                'gender' => $product->gender,
                'brand' => $product->brand,
                'category' => $product->category,
                'colorway' => $product->colorway,
                'stock' => $product->stock,
            ];
        })->toArray();
        return view('admin.product', compact('products'));
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'Xóa sản phẩm thành công!');
    }
    public function filter($filter, Request $request)
    {
        switch ($filter) {
            case 'men':
                $query = Product::where('gender', 'male')->orWhere('gender', 'unisex');
                break;
            case 'women':
                $query = Product::where('gender', 'female')->orWhere('gender', 'unisex');
                break;
            case 'sports':
                $query = Product::where('category', 'like', '%Thể thao%');
                break;
            case 'new-arrivals':
                $query = Product::orderBy('created_at', 'desc');
                break;
            case 'best-sellers':
                $query = Product::orderBy('stock', 'asc');
                break;
            case 'sneakers':
            default:
                $query = Product::query();
                break;
        }

        if ($request->filled('name')) {
            $query->whereIn('name', $request->input('name'));
        }

        if ($request->filled('gender')) {
            $query->whereIn('gender', $request->input('gender'));
        }

        if ($request->filled('colorway')) {
            $query->whereIn('colorway', $request->input('colorway'));
        }

        if ($request->filled('price')) {
            $query->where('price', '<=', $request->input('price'));
        }

        if ($request->filled('size')) {
            $sizes = $request->input('size');
            $query->where(function ($q) use ($sizes) {
                foreach ($sizes as $size) {
                    $q->orWhereJsonContains('available_sizes', $size);
                }
            });
        }
        $products = $query->get();

        $all = Product::all();
        $names = $all->pluck('name')->unique()->sort()->values();
        $genders = $all->pluck('gender')->unique()->sort()->values();
        $colorways = $all->pluck('colorway')->unique()->sort()->values();
        $sizes = $all->pluck('available_sizes')->filter()->flatten()->unique()->sort()->values();
        return view('shop.products', compact('products', 'filter', 'names', 'genders', 'colorways', 'sizes'));
    }

    public function show($id)
{
    $product = Product::with('images')->findOrFail($id);
    $mainImage = $product->image ?? 'default.jpg';
    $additionalImages = $product->images->sortBy('order')->take(4);
    $relatedProducts = Product::where('id', '!=', $product->id)
        ->inRandomOrder()
        ->limit(4)
        ->get();

    return view('shop.product-items', compact(
        'product', 
        'mainImage', 
        'additionalImages', 
        'relatedProducts'
    ));
}

    public function homepageProducts()
    {
        $newProducts = Product::latest()->take(8)->get();
        return view('layouts.layouts', compact('newProducts'));
    }
    public function search(Request $request)
    {
        $q = $request->input('q');
        $products = Product::when($q, function ($query) use ($q) {
            $query->where('name', 'like', "%$q%")
                ->orWhere('brand', 'like', "%$q%")
                ->orWhere('category', 'like', "%$q%")
                ->orWhere('colorway', 'like', "%$q%")
                ->orWhere('id', 'like', "%$q%") ;
        })
        ->latest()
        ->paginate(10);
        return view('admin.product', [
            'products' => $products,
        ]);
    }
    public function brandFilter($brand)
    {
        $products = Product::where('brand', $brand)->get();
        $filter = $brand;
        $all = Product::all();
        $names = $all->pluck('name')->unique()->sort()->values();
        $genders = $all->pluck('gender')->unique()->sort()->values();
        $colorways = $all->pluck('colorway')->unique()->sort()->values();
        $sizes = $all->pluck('available_sizes')->filter()->flatten()->unique()->sort()->values();
        return view('shop.products', compact('products', 'filter', 'names', 'genders', 'colorways', 'sizes'));
    }
}
