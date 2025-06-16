<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Blog;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $products = Product::query()
            ->where('name', 'like', "%$q%")
            ->orWhere('brand', 'like', "%$q%")
            ->orWhere('category', 'like', "%$q%")
            ->get();
        $blogs = Blog::query()
            ->where('title', 'like', "%$q%")
            ->orWhere('content', 'like', "%$q%")
            ->get();
        return view('search-results', compact('q', 'products', 'blogs'));
    }
}
